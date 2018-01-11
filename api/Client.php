<?php
/**
 *                       ######
 *                       ######
 * ############    ####( ######  #####. ######  ############   ############
 * #############  #####( ######  #####. ######  #############  #############
 *        ######  #####( ######  #####. ######  #####  ######  #####  ######
 * ###### ######  #####( ######  #####. ######  #####  #####   #####  ######
 * ###### ######  #####( ######  #####. ######  #####          #####  ######
 * #############  #############  #############  #############  #####  ######
 *  ############   ############  #############   ############  #####  ######
 *                                      ######
 *                               #############
 *                               ############
 *
 * Adyen Checkout Example (https://www.adyen.com/)
 *
 * Copyright (c) 2017 Adyen BV (https://www.adyen.com/)
 *
 */
require_once __DIR__ . '/../payment/order.php';
require_once __DIR__ . '/../config/server.php';

class Client
{
    public function __construct()
    {
    }

    private function _getAuthentication()
    {
        $authentication = array();
        if (!empty (getenv('MERCHANT_ACCOUNT')) && !empty(getenv('CHECKOUT_API_KEY'))) {
            $authentication['merchantAccount'] = getenv('MERCHANT_ACCOUNT');
            $authentication['checkoutAPIkey'] = getenv('CHECKOUT_API_KEY');
        } else {
            if (file_exists(__DIR__ . '/../config/authentication.ini')) {
                $authentication = parse_ini_file(__DIR__ . '/../config/authentication.ini', true);
            }
        }
        if (empty($authentication)) {
            echo "Authentication not set. Please check README file.";
        }
        return $authentication;
    }

    /** Set up the cURL call to  adyen */
    public function requestPaymentData()
    {
        $order = new Order();
        $server = new Server();
        $authentication = $this->_getAuthentication();
        $request = array(
            /** All order specific settings can be found in payment/order.php */

            'amount' => $order->getAmount(),
            'channel' => $order->getChannel(),
            'countryCode' => $order->getCountryCode(),
            'html' => $order->getHtml(),
            'shopperReference' => $order->getShopperReference(),
            'shopperLocale' => $order->getShopperLocale(),
            'reference' => $order->getReference(),

            /** All server specific settings can be found in config/server.php */

            'origin' => $server->getOrigin(),
            'shopperIP' => $server->getShopperIP(),
            'returnUrl' => $server->getReturnUrl(),

            /** All merchant/authentication specific settings can be found in config/authentication.php */

            'merchantAccount' => $authentication['merchantAccount']
        );

        $setupString = json_encode($request);
        //  Initiate curl
        $curlAPICall = curl_init();

        // Set to POST
        curl_setopt($curlAPICall, CURLOPT_CUSTOMREQUEST, "POST");

        // Add JSON message
        curl_setopt($curlAPICall, CURLOPT_POSTFIELDS, $setupString);

        // Will return the response, if false it print the response
        curl_setopt($curlAPICall, CURLOPT_RETURNTRANSFER, true);

        // Set the url
        curl_setopt($curlAPICall, CURLOPT_URL, $server->getSetupUrl());

        // Api key
        curl_setopt($curlAPICall, CURLOPT_HTTPHEADER,
            array(
                "X-Api-Key: " . $authentication['checkoutAPIkey'],
                "Content-Type: application/json",
                "Content-Length: " . strlen($setupString)
            )
        );

        // Execute
        $result = curl_exec($curlAPICall);

        // Closing
        curl_close($curlAPICall);

        // When this file gets called by javascript or another language, it will respond with a json object
        return $result;
    }

}


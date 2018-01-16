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
require_once __DIR__ . '/Order.php';
require_once __DIR__ . '/Config.php';

class Client
{

    public function setup()
    {
        $order = new Order();
        $authentication = Config::getAuthentication();
        $url = Config::getSetupUrl();
        $request = array(
            /** All order specific settings can be found in payment/Order.php */

            'amount' => $order->getAmount(),
            'channel' => $order->getChannel(),
            'countryCode' => $order->getCountryCode(),
            'html' => $order->getHtml(),
            'shopperReference' => $order->getShopperReference(),
            'shopperLocale' => $order->getShopperLocale(),
            'reference' => $order->getReference(),

            /** All server specific settings can be found in config/Config.php */

            'origin' => Config::getOrigin(),
            'shopperIP' => Config::getShopperIP(),
            'returnUrl' => Config::getReturnUrl(),

            /** All merchant/authentication specific settings can be found in config/authentication.php */

            'merchantAccount' => $authentication['merchantAccount']
        );
        $data = json_encode($request);
        return $this->doPostRequest($url, $data, $authentication);

    }

    public function verify($data)
    {
        $url = Config::getVerifyUrl();
        $authentication = Config::getAuthentication();
        return $this->doPostRequest($url, $data, $authentication);
    }

    /** Set up the cURL call to  adyen */
    private function doPostRequest($url, $data, $authentication)
    {
        //  Initiate curl
        $curlAPICall = curl_init();

        // Set to POST
        curl_setopt($curlAPICall, CURLOPT_CUSTOMREQUEST, "POST");

        // Will return the response, if false it print the response
        curl_setopt($curlAPICall, CURLOPT_RETURNTRANSFER, true);

        // Add JSON message
        curl_setopt($curlAPICall, CURLOPT_POSTFIELDS, $data);

        // Set the url
        curl_setopt($curlAPICall, CURLOPT_URL, $url);

        // Api key
        curl_setopt($curlAPICall, CURLOPT_HTTPHEADER,
            array(
                "X-Api-Key: " . $authentication['checkoutAPIkey'],
                "Content-Type: application/json",
                "Content-Length: " . strlen($data)
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


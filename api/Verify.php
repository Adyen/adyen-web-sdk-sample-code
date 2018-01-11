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

require_once __DIR__ . '/../config/server.php';

class Verify
{

    public function __construct()
    {
        $this->verifyPaymentData();
    }

    public function verifyPaymentData()
    {
        $server = new Server();
        $payload = json_encode($_POST['payloadData']);

        $authentication = $this->_getAuthentication();

        //  Initiate curl
        $curlAPICall = curl_init();

        // Set to POST
        curl_setopt($curlAPICall, CURLOPT_CUSTOMREQUEST, "POST");

        // Add JSON message
        curl_setopt($curlAPICall, CURLOPT_POSTFIELDS, $payload . payload);

        // Will return the response, if false it print the response
        curl_setopt($curlAPICall, CURLOPT_RETURNTRANSFER, true);

        // Set the url
        curl_setopt($curlAPICall, CURLOPT_URL, $server->getVerifyUrl());

        // Api key
        curl_setopt($curlAPICall, CURLOPT_HTTPHEADER,
            array(
                "X-Api-Key: " . $authentication['checkoutAPIkey'],
                "Content-Type: application/json",
                "Content-Length: " . strlen($payload)
            )
        );

        // Execute
        $result = curl_exec($curlAPICall);

        // Closing
        curl_close($curlAPICall);

        // When this file gets called by javascript or another language, it will respond with a json object
        echo $result;
    }

    private function _getAuthentication()
    {
        $authentication = array();
        if (!empty (getenv('MERCHANT_ACCOUNT')) && !empty(getenv('CHECKOUT_API_KEY'))) {
            $authentication['merchantAccount'] = getenv('MERCHANT_ACCOUNT');
            $authentication['checkoutAPIkey'] = getenv('CHECKOUT_API_KEY');
        } else {
            $authentication = parse_ini_file(__DIR__ . '/../config/authentication.ini', true);
        }
        return $authentication;
    }
}

new Verify();
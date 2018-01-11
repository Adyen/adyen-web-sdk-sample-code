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
class Server
{
    const ENDPOINT_TEST = "https://checkout-test.adyen.com/services/PaymentSetupAndVerification";
    const VERSION = "/v32";
    const SETUP = "/setup";
    const VERIFY = "/verify";

    /** Function to define the protocol and base URL */
    public function url()
    {
        if (!empty (getenv('PROTOCOL'))) {
            $protocol = getenv('PROTOCOL');
        } else {
            $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https' : 'http';
        }

        return sprintf(
            "%s://%s", $protocol, $_SERVER['HTTP_HOST']
        );
    }

    public function getOrigin()
    {
        return SELF::url();
    }

    public function getShopperIP()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public function getReturnUrl()
    {
        return SELF::url();
    }

    public function getSetupUrl()
    {
        return self::ENDPOINT_TEST . self::VERSION . self::SETUP;
    }

    public function getVerifyUrl()
    {
        return self::ENDPOINT_TEST . self::VERSION . self::VERIFY;
    }
}
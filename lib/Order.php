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

/**
 * Set up / edit your order on this page
 * For more information, refer to the checkout API documentation: https://docs.adyen.com/developers/checkout/api-reference-checkout */
class Order
{
    /** @int value - Put the value into minor units 120 = 1.20 (for USD), for decimal information per currency see: https://docs.adyen.com/developers/currency-codes */
    public $value = 120;

    /** @var  $currencyCode - Change this to any currency you support: https://docs.adyen.com/developers/currency-codes */
    public $currencyCode = 'USD';

    /** @array $amount - Amount is a combination of value and currency */
    public $amount = ['value' => 120, 'currency' => "USD"];

    public function getAmount()
    {
        return $this->amount;
    }

    /** @var $reference - order number */
    public $reference = 'order_id';

    public function getReference()
    {
        return $this->reference;
    }

    /** @var $shopperReference - Your shopper reference (id or e-mail are commonly used) */
    public $shopperReference = 'example_shopper';

    public function getShopperReference()
    {
        return $this->shopperReference;
    }

    /** @var $shopperLocale - The shopper locale : https://docs.adyen.com/developers/in-app-integration/checkout-api-reference/setup */
    public $shopperLocale = 'en_US';

    public function getShopperLocale()
    {
        return $this->shopperLocale;
    }

    /** @var $countryCode - The countryCode influences the returned payment methods */
    public $countryCode = 'FR';

    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /** @var $channel - the channel influences the returned payment methods (the same server can be used for iOS, Android and Point of sale */
    public $channel = 'Web';

    public function getChannel()
    {
        return $this->channel;
    }

    public $html = true;

    public function getHtml()
    {
        return $this->html;
    }

}
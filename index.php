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
 * Author: Adyen
 */
require_once __DIR__ . '/lib/Client.php';
date_default_timezone_set("Europe/Amsterdam");
?>

<!DOCTYPE html>
<html class="html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="robots" content="noindex"/>
    <title>Example PHP checkout</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript"
            src="https://checkoutshopper-test.adyen.com/checkoutshopper/assets/js/sdk/checkoutSDK.1.2.0.min.js"></script>
    <script src="assets/js/setupCall.js" type="text/javascript"></script>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="body">
<div class="content">
    <div class="explanation hidden">
        <h3>To run this web checkout example, edit the following variables in the <b>config/authentication.ini</b> file:
        </h3>
        <p>
            <b>merchantAccount</b>= "YOUR MERCHANT ACCOUNT", more information in our <a
                    href="https://docs.adyen.com/developers/get-started-with-adyen/create-a-test-account"
                    target="_blank">Getting
                started guide</a>.<br/>
            <b>checkoutAPIkey</b>= "YOUR CHECKOUT API KEY".<a
                    href="https://docs.adyen.com/developers/user-management/how-to-get-the-checkout-api-key"
                    target="_blank">Checkout API key</a>.<br/>
        </p>
        <p>
            For a full reference of the documentation, visit: <a
                    href="https://docs.adyen.com/developers/checkout/web-sdk" target="_blank">Checkout Web SDK</a>
        </p>
    </div>

    <div class="checkout-container">
        <div class="checkout" id="checkout">
            <!-- The checkout interface will be rendered here -->
        </div>
    </div>
</div>
<?php
$client = new Client();
$setupData = json_encode($client->setup());


?>
<script type="text/javascript">
    $(document).ready(function () {
        var data = <?php echo $setupData ?>;
        initiateCheckout(data);
        chckt.hooks.beforeComplete = function (node, paymentData) {
            // `node` is a reference to the Checkout container HTML node.
            // `paymentData` is the result of the payment. Includes the `payload` variable,
            // which you should submit to the server for the Checkout API /verify call.
            $.ajax({
                url: 'verify.php',
                data: {payloadData: paymentData},
                method: 'POST',// jQuery > 1.9
                type: 'POST', //jQuery < 1.9
                success: function (data) {
                    $("#checkout").html(data.authResponse);
                },
                error: function () {
                    if (window.console && console.log) {
                        console.log('### adyenCheckout::error:: args=', arguments);
                    }
                }
            });

            return false; // Indicates that you want to replace the default handling.
        };
    });
</script>
</body>
</html>
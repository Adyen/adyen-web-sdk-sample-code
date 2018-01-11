var showHint = false;

// Functionality around showing hint on how to configure the 'setup' call
var explanationDiv = $('.explanation');
explanationDiv.hide();

function showExplanation() {
    if (showHint) {
        explanationDiv.show();
    }
}

window.setTimeout(showExplanation, 4000);

/////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// CONFIGURATION OF CHECKOUT /////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

// Object which allows you to style the securedFields (Adyen hosted iframes) view all configurable style options here: https://docs.adyen.com/developers/checkout/web-sdk/custom-checkout-web
var securedFieldsStyles = {
    base: {
        fontSize: '16px'
    },

    error: {
        color: 'red'
    },

    placeholder: {
        color: '#d8d8d8'
    },

    validated: {
        color: 'green'
    }
};

// You are able to overwrite any language string per locale, by sending in a translationUbject see https://docs.adyen.com/developers/checkout/web-sdk/custom-checkout-web/translations
var translationObject = {
    "paymentMethods.moreMethodsButton": {
        "en-US": "Other payment methods",
        "nl-NL": "Meer opties"
    }
};

// For a full reference of configurable options, view https://docs.adyen.com/developers/checkout/web-sdk/custom-checkout-web/sdk-configuration
var configurationObject = {
    context: 'test',
    translations: translationObject,
    paymentMethods: {
        card: {
            sfStyles: securedFieldsStyles,
            showOptionalHolderNameField: true
        }
    }
};

/////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// INITIALIZE CHECKOUT ////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * @function Renders the JSON response from the 'setup' call as a fully functioning Checkout page
 *
 * Uses the 'checkout' property on the global var 'chckt' which is created when checkoutSDK.min.js is loaded
 *
 * @param jsonResponseObject - the JSON response from the 'setup' call to the Adyen CheckoutAPI
 */
function initiateCheckout(jsonResponse) {
    var checkout = chckt.checkout(jsonResponse, '.checkout', configurationObject);
};




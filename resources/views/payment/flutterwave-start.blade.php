<!DOCTYPE html>
<html lang="en">
    <head>
        <title>flutter payment</title>
        <script src="https://checkout.flutterwave.com/v3.js"></script>
    </head>
    <body>
    </body>
    <script>
        FlutterwaveCheckout({
            public_key: "FLWPUBK_TEST-0c1e95aa9cc0953c40ce3f504bde6736-X",
            tx_ref: "hooli-tx-1920bbtyt",
            amount: 54600,
            currency: "NGN",
            country: "NG",
            payment_options: "card, mobilemoneyghana, ussd",
            redirect_url: // specified redirect URL
                "https://callbacks.piedpiper.com/flutterwave.aspx?ismobile=34",
            meta: {
                consumer_id: 23,
                consumer_mac: "92a3-912ba-1192a",
            },
            customer: {
                email: "denkogee11@gmail.com",
                phone_number: "08163394819",
                name: "David Kalu",
            },
            callback: function (data) {
                console.log(data);
            },
            onclose: function() {
                // close modal
            },
            customizations: {
                title: "My store",
                description: "Payment for items in cart",
                logo: "https://assets.piedpiper.com/logo.png",
            },
            });
    </script>
</html>
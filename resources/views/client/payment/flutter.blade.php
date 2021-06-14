<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Fix Master</title>
        <script src="https://checkout.flutterwave.com/v3.js"></script>
    </head>
    <body>
    </body>
    <script>
        FlutterwaveCheckout({
            public_key: "FLWPUBK_TEST-0c1e95aa9cc0953c40ce3f504bde6736-X",
            tx_ref: "{{ $flutter['track'] }}",
            amount: {{ floatval($flutter['amount']) }},
            currency: "NGN",
            payment_options: "card, mobilemoneyghana, ussd",
            redirect_url: "{{route('client.ipn.flutter', app()->getLocale())}}",
            customer: {
              email: "{{$client->email}}",
              name: "{{$client->name}}",
            },
            callback: function (data) {
              console.log(data);
            },
            onclose: function() {
              window.location.href = "{{route('client.wallet', app()->getLocale())}}"
            },
            customizations: {
              title: "FixMaster",
              description: "Towards E-wallet deposit",
            },
        });
    </script>
</html>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" type="text/css" />

<style>
    .blog .author { opacity: 1 !important; }
    .blog .overlay { opacity: 0.6 !important; }
    .avatar.avatar-ex-smm { max-height: 75px; }

    .cc-selector input{
        margin:0;padding:0;
        -webkit-appearance:none;
        -moz-appearance:none;
                appearance:none;
    }
    .paystack{background-image:url({{ asset('assets/images') }}/paystack.png);}
    .flutter{background-image:url({{ asset('assets/images') }}/flutter.png);}

    .cc-selector input:active +.drinkcard-cc{opacity: .5;}
    .cc-selector input:checked +.drinkcard-cc{
        -webkit-filter: none;
        -moz-filter: none;
                filter: none;
    }
    .drinkcard-cc{
        cursor:pointer;
        background-size:contain;
        background-repeat:no-repeat;
        display:inline-block;
        width:100px;height:10em;
        -webkit-transition: all 100ms ease-in;
        -moz-transition: all 100ms ease-in;
                transition: all 100ms ease-in;
        -webkit-filter: brightness(1.8) grayscale(1) opacity(.7);
        -moz-filter: brightness(1.8) grayscale(1) opacity(.7);
                filter: brightness(1.8) grayscale(1) opacity(.7);
    }
    .drinkcard-cc:hover{
        -webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
        -moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
                filter: brightness(1.2) grayscale(.5) opacity(.9);
    }

    /* Extras */
    a:visited{color:#888}
    a{color:#999;text-decoration:none;}
    p{margin-bottom:.3em;}

    .address-hide{
        display:none;
    }

    table.scroll {
        /* width: 100%; */ /* Optional */
        /* border-collapse: collapse; */
        border-spacing: 0;
        /* border: 2px solid black; */
    }

    table.scroll tbody, table.scroll thead { display: block; }

    thead tr th { 
        height: 30px;
        line-height: 30px;
        /* text-align: left; */
    }

    table.scroll tbody {
        height: 10em;
        overflow-y: auto;
        overflow-x: hidden;
    }

    tbody { border-top: 2px solid black; }

    tbody td, thead th {
        /* width: 20%; */ /* Optional */
        border-right: 1px solid black;
        /* white-space: nowrap; */
    }

    tbody td:last-child, thead th:last-child {
        border-right: none;
    }

    .payment-container {
        display: flex;
        flex-flow: row wrap;
    }
    .payment-container > .payment-radio-container {
        flex: 1;
        padding: 0.5rem;
    }

    input[type="radio"] {
        display: none;
    }

    input[type="radio"]:not(:disabled) ~ .pplogo-container {
        cursor: pointer;
    }

    input[type="radio"]:disabled ~ .pplogo-container {
        color: #2251fc;
        border-color: #2251fc;
        box-shadow: none;
        cursor: not-allowed;
    }
    .pplogo-container {
        height: 150px;
        display: flex;
        justify-content:canter;
        align-items:center;
        width:200px;
        background: white;
        border: 2px solid #2251fc;
        border-radius: 20px;
        padding: 1rem;
        //margin-bottom: 1rem;
        box-shadow: 0px 3px 10px -2px rgba(34, 81, 252, 0.5);
        position: relative;
    }
    input[type="radio"]:checked + .pplogo-container {
        //background: #2251fc;
        color: white;
        box-shadow: 0px 0px 20px rgba(34, 81, 252, 0.75);
    }
    input[type="radio"]:checked + .pplogo-container::after {
        content: "\f058";
        font-family: "Font Awesome 5 Free";
        color: #2251fc;  
        border: 1px solid #2251fc;
        font-size: 2.5rem;
        font-weight:100;
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        height: 50px;
        width: 50px;
        line-height: 49px;
        text-align: center;
        border-radius: 50%;
        background: white;
        box-shadow: 0px 2px 5px -2px rgba(0, 0, 0, 0.25);
    }
    p {
        font-weight: 900;
    }
    @media only screen and (max-width: 700px) {
        section {
            flex-direction: column;
        }
    }

    .pac-container {
        z-index: 100000;
    }

    tbody td, thead th {
        width: 20% !important;
    }

    .text-small{ font-size: 12px !important; }
    .text-small-2{ font-size: 13px !important; }

    .invalid-response{
        font-size: 11px !important;
        color: #e43f52;
    }
</style>


{{-- <div class="row mx-auto p-4 cc-selector d-none payment-options">   
    <div class="col-md-6 payment-radio-container">
    
        <input type="radio" id="flutter" name="payment_channel" class="input-check" value="flutterwave" data-tabid="flutterwave" data-action="{{route('flutterwave-submit', app()->getLocale()) }}" > 
        <label for="flutter" class="pplogo-container">
        <img class="img-fluid" alt="flutter"src="{{ asset('assets/images') }}/flutter.png">              
        </label>
    </div>
    
    <div class="col-md-6 payment-radio-container">
        <input type="radio" id="paystack" name="payment_channel" class="input-check" value="paystack" data-tabid="paystack" data-action="{{route('paystack-submit', app()->getLocale()) }}" > 
        <label for="paystack" class="pplogo-container">
        <img class="img-fluid" alt="paystack"src="{{ asset('assets/images') }}/paystack.png">             
        </label>
    </div>
</div> --}}
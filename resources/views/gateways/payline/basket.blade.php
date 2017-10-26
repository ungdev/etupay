@if(config('payment.payline.env') == 'PROD')

    <link href="https://payment.payline.com/styles/widget-min.css" rel="stylesheet" />
    <script src="https://payment.payline.com/scripts/widget-min.js"></script>
@else

    <link href="https://homologation-payment.payline.com/styles/widget-min.css" rel="stylesheet" />
    <script src="https://homologation-payment.payline.com/scripts/widget-min.js"></script>
@endif
<style>
    .PaylineWidget.pl-container-default .pl-container-view
    {
        max-width: none;
    }

    .PaylineWidget .pl-ticket-view
    {
        margin:none;
    }
</style>

        <div id="PaylineWidget"
             data-token="{{ $payline_token }}"
             data-template="column"
             data-embeddedredirectionallowed="false"
        />
    </div>

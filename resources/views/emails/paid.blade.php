<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ $sujet }}</title>


</head>
<body style="-webkit-text-size-adjust: none; box-sizing: border-box; color: #74787E; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; height: 100%; line-height: 1.4; margin: 0; width: 100% !important;" bgcolor="#F2F4F6"><style type="text/css">
    body {
        width: 100% !important; height: 100%; margin: 0; line-height: 1.4; background-color: #F2F4F6; color: #74787E; -webkit-text-size-adjust: none;
    }
    @media only screen and (max-width: 600px) {
        .email-body_inner {
            width: 100% !important;
        }
        .email-footer {
            width: 100% !important;
        }
    }
    @media only screen and (max-width: 500px) {
        .button {
            width: 100% !important;
        }
    }
</style>
<span class="preheader" style="box-sizing: border-box; display: none !important; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 1px; line-height: 1px; max-height: 0; max-width: 0; mso-hide: all; opacity: 0; overflow: hidden; visibility: hidden;"></span>
<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;" bgcolor="#F2F4F6">
    <tr>
        <td align="center" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;">
            <table class="email-content" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;">
                <tr>
                    <td class="email-masthead" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; padding: 25px 0; word-break: break-word;" align="center">
                        <a href="https://etupay.utt.fr" class="email-masthead_name" style="box-sizing: border-box; color: #bbbfc3; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 16px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
                           {{ $sujet }}
                        </a>
                    </td>
                </tr>

                <tr>
                    <td class="email-body" width="100%" cellpadding="0" cellspacing="0" style="-premailer-cellpadding: 0; -premailer-cellspacing: 0; border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0; padding: 0; width: 100%; word-break: break-word;" bgcolor="#FFFFFF">
                        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0 auto; padding: 0; width: 570px;" bgcolor="#FFFFFF">

                            <tr>
                                <td class="content-cell" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; padding: 35px; word-break: break-word;">
                                    <h1 style="box-sizing: border-box; color: #2F3133; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 19px; font-weight: bold; margin-top: 0;" align="left">Bonjour {{ $transaction->firstname }},</h1>
                                    <p style="box-sizing: border-box; color: #74787E; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Votre transaction effectuée sur le service {{ $transaction->service->host }} a bien été enregistrée</p>
                                    <p style="box-sizing: border-box; color: #74787E; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Cette dernière apparaitra comme provenant de "BDE UTT" sur votre prochain relevé bancaire.</p>


                                    <table class="purchase" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0; padding: 35px 0; width: 100%;">
                                        <tr>
                                            <td style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;">
                                                <h3 style="box-sizing: border-box; color: #2F3133; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 14px; font-weight: bold; margin-top: 0;" align="left">EtuPay #{{ $transaction->id }}</h3></td>
                                            <td style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;">
                                                <h3 class="align-right" style="box-sizing: border-box; color: #2F3133; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 14px; font-weight: bold; margin-top: 0;" align="right">{{ $transaction->created_at->format('d-m-Y') }}</h3></td>
                                        </tr>
                                        <tr>
                                            <td style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;">
                                                <h3 style="box-sizing: border-box; color: #2F3133; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 14px; font-style: italic ; margin-top: 0;" align="left">{{ $transaction->getProvider()->getHumanisedReport($transaction) }}</h3></td>
                                            <td style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;">
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;">
                                                <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0; padding: 25px 0 0; width: 100%;">
                                                    <tr>
                                                        <th class="purchase_heading" style="border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-bottom: 8px;">
                                                            <p style="box-sizing: border-box; color: #9BA2AB; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin: 0;" align="left">Description</p>
                                                        </th>
                                                        <th class="purchase_heading" style="border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-bottom: 8px;">
                                                            <p class="align-right" style="box-sizing: border-box; color: #9BA2AB; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin: 0;" align="right">Quantité x Prix</p>
                                                        </th>
                                                    </tr>
                                                    @if($transaction->articles)
                                                        @foreach($transaction->articles as $article)
                                                        <tr>
                                                            <td width="80%" class="purchase_item" style="box-sizing: border-box; color: #74787E; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 15px; line-height: 18px; padding: 10px 0; word-break: break-word;">{{ $article['name'] }}</td>
                                                            <td class="align-right" width="20%" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;" align="right">{{ $article['qty'] }} x {{ $article['price']/100 }} €</td>
                                                        </tr>
                                                        @endforeach
                                                    @endif
                                                        <tr>
                                                            <td width="80%" class="purchase_footer" valign="middle" style="border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-top: 15px; word-break: break-word;">
                                                                <p class="purchase_total purchase_total--label" style="box-sizing: border-box; color: #2F3133; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 16px; font-weight: bold; line-height: 1.5em; margin: 0; padding: 0 15px 0 0;" align="right">Total</p>
                                                            </td>
                                                            <td width="20%" class="purchase_footer" valign="middle" style="border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-top: 15px; word-break: break-word;">
                                                                <p class="purchase_total" style="box-sizing: border-box; color: #2F3133; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 16px; font-weight: bold; line-height: 1.5em; margin: 0;" align="right">{{ $transaction->amount/100 }} €</p>
                                                            </td>
                                                        </tr>

                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <p style="box-sizing: border-box; color: #74787E; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">Si vous avez des questions à propos de ce mail, répondez-y simplement.</p>
                                    <p style="box-sizing: border-box; color: #74787E; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">A bientôt,
                                        <br />L'équipe du BDE</p>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; word-break: break-word;">
                        <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
                            <tr>
                                <td class="content-cell" align="center" style="box-sizing: border-box; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; padding: 35px; word-break: break-word;">
                                    <p class="sub align-center" style="box-sizing: border-box; color: #AEAEAE; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center"> EtuPay, plateforme de paiement associative © {{ date('Y') }} BDE UTT. All rights reserved.</p>
                                    <p class="sub align-center" style="box-sizing: border-box; color: #AEAEAE; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">
                                        BDE UTT
                                        <br />12 rue marie curie
                                        <br />10000 Troyes
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
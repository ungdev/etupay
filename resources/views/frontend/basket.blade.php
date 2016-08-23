@extends('layouts.dashboard')

@section('title', 'Paiment en ligne')

@section('smalltitle', $transaction->service->description)

@section('content')
    @if($transaction instanceof \App\Models\AuthorisationTransaction)
        <div class="callout callout-info">
            <h4>Caution bancaire</h4>

            <p>Dans le cadre de cette transaction, seul une authorisation bancaire sera effectué auprés de votre banque. Le montant ne sera pas débité !</p>
        </div>
    @endif

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-eur"></i> Récapitulatif</h3>
        </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover" id="basket">
                    @if(is_array($transaction->articles))
                    <thead>
                    <tr>
                        <th></th>
                        <th>Prix</th>
                        <th>Quantité</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transaction->articles as $article)
                    <tr class="vert-align">
                        <td>
                            <strong>{{ $article['name'] }}</strong>
                        </td>
                        <td class="price">{{ $article['price']/100 }} €</td>
                        <td>{{ $article['qty'] }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                    @endif
                    <tfoot>
                    <tr class="vert-align">
                        <th class="text-right">
                            Total :
                        </th>
                        <th id="total">{{ round($transaction->amount/100,2) }} €</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
    </div>

    @foreach($gateways as $gateway)
        {!! $gateway->getChoosePage($transaction) !!}
    @endforeach
@endsection
@extends('layouts.dashboard')

@section('title', 'Paiement en ligne, pour le compte '.$transaction->service->fundation->name_prefix.$transaction->service->fundation->name)

@section('smalltitle', $transaction->service->description)

@section('content')
    @if($transaction instanceof \App\Models\AuthorisationTransaction)
        <div class="callout callout-info">
            <h4>Caution bancaire</h4>

            <p>Dans le cadre de cette transaction, seule une autorisation bancaire d'un montant de {{ $transaction->amount/100 }}€ et pour une durée limitée sera effectuée auprès de votre banque. Le montant ne sera pas débité !</p>
        </div>
    @endif
    @if($transaction->service->isDevMode())
    <div class="callout callout-warning">
        <h4>Mode développeur</h4>

        <p>La transaction ne pourra donner lieu à une preuve de paiment s'agissant d'un comportement simulé. Aucun prélévement ne sera effectué sur votre compte !</p>
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
@extends('layouts.material')

@section('title', 'Paiement en ligne, pour le compte '.$transaction->service->fundation->name_prefix.$transaction->service->fundation->name)

@section('smalltitle', $transaction->service->description)

@section('content')
<div class="wizard-navigation">
        <ul>
            <li><a href="#details" data-toggle="tab">Informations</a></li>
            <li><a href="#panier" data-toggle="tab">Récapitulatif</a></li>
            <li><a href="#paiement" data-toggle="tab">Paiement</a></li>
        </ul>
    </div>

    <div class="tab-content">
        <div class="tab-pane" id="details">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="info-text"> Commençons par vérifier vos informations de facturation</h4>
                    
                </div>
            <form id="details_form" action="{{ url()->route('api.v1.transaction.selfUpdate', ['InitialisedTransactionUUID' => $transaction->uuid]) }}">
                <div class="col-sm-6">
                    <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">face</i>
                            </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Votre nom</label>
                                <input name="lastname" type="text" class="form-control" value="{{ $transaction->lastname }}">
                            </div>
                    </div>
                    <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">face</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Votre prénom</label>
                                    <input name="firstname" type="text" class="form-control" value="{{ $transaction->firstname }}">
                                </div>
                        </div>
                    

                </div>
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-group label-floating">
                              <label class="control-label">Votre adresse e-mail</label>
                              <input name="client_mail" type="text" class="form-control" value="{{ $transaction->client_mail }}">
                        </div>
                    </div>    
                </div>
            </form>
            </div>
        </div>
        <div class="tab-pane" id="panier">
            <h4 class="info-text">Vérifions le contenu maintenant ... </h4>
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
        <div class="tab-pane" id="paiement">
            @if($transaction instanceof \App\Models\AuthorisationTransaction)
                <div class="alert alert-info" role="alert">
                <h4>Caution bancaire</h4>
                <p>Dans le cadre de cette transaction, seule une autorisation bancaire d'un montant de {{ $transaction->amount/100 }}€ et pour une durée limitée sera effectuée auprès de votre banque. Le montant ne sera pas débité !</p>
                </div>
            @endif
            @if($transaction->service->isDevMode())
            <div class="alert alert-warning" role="alert">
                <h4>Mode développeur</h4>
        
                <p>La transaction ne pourra donner lieu à une preuve de paiment s'agissant d'un comportement simulé. Aucun prélévement ne sera effectué sur votre compte !</p>
            </div>
            @endif
            @foreach($gateways as $gateway)
                {!! $gateway->getChoosePage($transaction) !!}
            @endforeach
        </div>
    </div>
    <div class="wizard-footer">
            <div class="pull-right">
                <input type='button' class='btn btn-next btn-fill btn-danger btn-wd' name='next' value='Suivant' />
            </div>
            <div class="pull-left">
                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Précédent' />

            </div>
            <div class="clearfix"></div>
        </div>
@endsection
@extends('layouts.dashboard)

@section('title', 'Panier')

@section('smalltitle', 'Choix du moyen de paiment')

@section('content')
    <div class="box box-default">
        <form action="http://192.168.0.181/wei/pay" method="post">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover" id="basket">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Prix</th>
                        <th>Quantité</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="vert-align">
                        <td>
                            <strong>Week-end d'intégration</strong>
                            <ul>
                                <li>Départ le vendredi 9 septembre 2016 à 11h30</li>
                                <li>Retour à Troyes le dimanche vers 19h</li>
                                <li>Hébergement compris (sauf sac de couchage)</li>
                                <li>Repas compris</li>
                            </ul>
                        </td>
                        <td class="price">1.00 €</td>
                        <td>
                            <select name="wei" class="quantity">
                                <option value="1">1</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="vert-align">
                        <td>
                            <strong>Panier repas du vendredi midi</strong>

                            <p>
                                Le départ au weekend se faisant à partir de 11h30, vous n'aurez généralement pas le temps d'aller acheter à manger, (sauf si vous l'avez préparé avant).<br/>
                                Nous vous proposons donc un panier repas (sandwich, chips, fruit et bouteille d'eau) préparé par le CROUS (qui gère le restaurant universitaire).<br/>
                                Si tu as un régime particulier (sans porc, vegetarien, ...) pense à préciser dans <em>régime particulier</em> sur ton profil.
                            </p>
                        </td>
                        <td class="price">1.00 €</td>
                        <td>
                            <select name="sandwich" class="quantity">
                                <option value="0" >0</option>
                                <option value="1"  selected="selected" >1</option>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr class="vert-align">
                        <th class="text-right">
                            Total :
                        </th>
                        <th id="total"></th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="box-body">
                <div class="checkbox">
                    <label><input type="checkbox" name="cgv"> J'accepte les <a href="#">Conditions générales de vente</a></label>
                </div>
                <input type="submit" class="btn btn-success form-control" value="Payer"/>
                <div class="text-center">
                    <a href="#cannotpay" data-toggle="collapse">Je ne peux pas payer en ligne !</a>
                    <p id="cannotpay" class="collapse">
                        Il faudra passer nous voir à la rentrée pour payer par chèque au nom de <em>BDE UTT</em>, par carte bancaire ou en espèce.<br/>
                        <a href="http://192.168.0.181/wei/guarantee" class="btn btn-warning">Je viendrais payer à la rentrée</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
@endsection
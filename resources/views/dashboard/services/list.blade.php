@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection
@section('contentheader_title', 'Gestion des services')
@section('contentheader_description', 'Liste')

@section('main-content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Résumé</h3>
        </div>
        <div class="box-body">
            <table class="table table-hover" id="services_table">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Nom du service</th>
                    <th>Fondation</th>
                    <th>Etat</th>
                    <th># Transactions</th>
                    <th>Solde</th>
                    <th>Reversé</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($services as $service)
                    <tr class="vert-align">
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->host }}</td>
                        <td>{{ $service->fundation->name }}</td>
                        <td> @if($service->isDisabled) <i class="label label-danger">Désactivé</i> @else <i class="label label-success">Activé</i> @endif</td>
                        <td>{{ number_format($service->transactions_count,0,'.', ' ') }}</td>
                        <td>{{ number_format($service->getSolde()/100,0,'.', ' ') }} €</td>
                        <td>{{ number_format($service->repaymentsAmount()/100,0,'.', ' ') }} €</td>
                        <td><a href="#" class="btn btn-flat btn-xs btn-info"><i class="glyphicon glyphicon-wrench"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js_addons')
    @parent
    <script src="{{ @asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ @asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function () {
            $("#services_table").DataTable();
        });
    </script>
@endsection
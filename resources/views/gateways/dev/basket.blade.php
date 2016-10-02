

<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-cubes"></i> Mode développeur</h3>
    </div>
    <div class="box-body">
        <a class="btn btn-success btn-block" href="{{ route('userFrontend.devMode', ['InitialisedTransaction'=>$transaction,'action'=>'success' ]) }}">
            Valider la transaction
        </a>
        <a class="btn btn-info btn-block" href="{{ route('userFrontend.devMode', ['InitialisedTransaction'=>$transaction,'action'=>'canceled' ]) }}">
            Annuler la transaction
        </a>
        <a class="btn btn-danger btn-block" href="{{ route('userFrontend.devMode', ['InitialisedTransaction'=>$transaction,'action'=>'refused' ]) }}">
            Refuser la transaction
        </a>
    </div>
</div>
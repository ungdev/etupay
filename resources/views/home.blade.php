@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection
@section('contentheader_title', 'Tableau de bord')
@section('contentheader_description', '')

@section('main-content')
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-globe"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Services</span>
					<span class="info-box-number">{{ Auth::user()->getAdminServicesQuery()->count() }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->

		<!-- fix for small devices only -->
		<div class="clearfix visible-sm-block"></div>

		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-green"><i class="glyphicon glyphicon-shopping-cart"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Transactions</span>
					<span class="info-box-number">{{ number_format(Auth::user()->getAdminServicesQuery()->withCount(['transactions'=> function ($query) { $query->where('step','PAID');}])->get()->sum('transactions_count'), 0, ',', ' ') }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->

		<div class="clearfix visible-sm-block"></div>

		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-red"><i class="glyphicon glyphicon-euro"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">CA</span>
					<span class="info-box-number">{{ number_format($total_ca, 0, ',', ' ') }} €</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>

		<!-- /.col -->
	</div>

	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Welcome</h3>
		</div>
		<div class="box-body">
			<p>Accédez aux fonctionnalités à l'aide du menu situé sur la gauche.</p>
		</div>
	</div>
@endsection

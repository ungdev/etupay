<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>EtuPay - @yield('title')</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<link rel="apple-touch-icon" sizes="76x76" href="{{ @asset('img/logo.png') }}" />
	<link rel="icon" type="image/png" href="{{ @asset('favicon.ico') }}" />

	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- CSS Files -->
	<link href="{{ @asset('css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ @asset('css/material-boostrap.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="se-pre-con"></div>
	<div class="image-container set-full-height" style="background-image: url('{{ @asset('images/utt.jpg') }}')">
	    <!--   Big container   -->
	    <div class="container">
	        <div class="row">
		        <div class="col-sm-8 col-sm-offset-2">
		            <!--      Wizard container        -->
		            <div class="wizard-container">
		                <div class="card wizard-card" data-color="blue" id="wizard">
		                    	<div class="wizard-header">
		                        	<h3 class="wizard-title">
                                        <img src="{{ @asset('images/logo_openning.gif') }}" height="200px" />
                                    </h3>
									<h5><b>EtuPay</b>, le système de paiement associatif</h5>
									
                                </div>
                                
								@yield('content')
		                </div>
		            </div> <!-- wizard container -->
		        </div>
	    	</div> <!-- row -->
		</div> <!--  big container -->

	    <div class="footer">
	        <div class="container text-center">
	             Développé avec <i class="fa fa-heart heart"></i> par <a href="https://github.com/ChrisdAutume/">Christian d'Autume</a>.
	        </div>
	    </div>
	</div>

</body>
	<!--   Core JS Files   -->
	<script
			  src="https://code.jquery.com/jquery-2.2.4.min.js"
			  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
			  crossorigin="anonymous"></script>
	<script src="{{ @asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ @asset('js/jquery.bootstrap.js') }}" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="{{ @asset('js/material-bootstrap-wizard.js') }}"></script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="{{ @asset('js/jquery.validate.min.js') }}"></script>
	<script src="{{ @asset('js/jquery.noty.packaged.min.js') }}"></script>
</html>

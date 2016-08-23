@extends('layouts.master')

@section('css')
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ @asset('/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ @asset('/css/skins/skin-blue.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('bodycontent')
    <div class="skin-blue layout-top-nav">
        <div class="wrapper">
            <header class="main-header">
            </header>

            <div class="content-wrapper">
                <div class="container">
                    <section class="content-header">
                        @include('display-errors')
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h1>
                            @yield('title')
                            <small>@yield('smalltitle')</small>
                        </h1>
                    </section>
                    <section class="content">
                        @yield('content')
                    </section>
                </div>
            </div>

            <footer class="main-footer">
                <div class="container">
                    <div class="pull-right hidden-xs">
                    </div>
                    <strong>En cas de problème,</strong> contacter <a href="mailto:christian+etupay@dautume.fr">Chris</a>.
                </div>
            </footer>
        </div>
    </div>
@endsection

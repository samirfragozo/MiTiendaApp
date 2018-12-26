@extends('layouts.base')

@section('body')
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
    <div class="m-grid m-grid--hor m-grid--root m-page">
        @include('includes.header')
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
            {{ (new \App\Utils\Base())->menu() }}
            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div id="app" class="m-content m--padding-15">
                    @yield('content')
                </div>
            </div>
            <div id="modals">
            </div>
        </div>
        @include('includes.footer')
    </div>
    </body>
@endsection

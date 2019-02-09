@extends('layouts.auth')

@php($crud = 'email')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form class="m-login__form m-form" action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="form-group m-form__group">
            <input class="form-control m-input{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" placeholder="{{ __('validation.attributes.email') }}" name="email" value="{{ old('email') }}" required autofocus>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="m-login__form-action">
            <button class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air" type="submit">{{__('base.buttons.submit')}}</button>&nbsp;&nbsp;
            <a href="{{ route('home') }}" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">{{__('base.buttons.cancel')}}</a>
        </div>
    </form>
@endsection

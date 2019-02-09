@extends('layouts.auth')

@php($crud = 'reset')

@section('content')
    <form class="m-login__form m-form" action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group m-form__group">
            <input class="form-control m-input{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" placeholder="{{ __('validation.attributes.email') }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group m-form__group">
            <input class="form-control m-input{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" placeholder="{{ __('validation.attributes.password') }}" name="password" autocomplete="off" required>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group m-form__group">
            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="{{ __('validation.attributes.password_confirmation') }}" name="password_confirmation" autocomplete="off" required>
        </div>
        <div class="m-login__form-action">
            <button class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air" type="submit">{{__('base.buttons.submit')}}</button>&nbsp;&nbsp;
            <a href="{{ route('home') }}" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">{{__('base.buttons.cancel')}}</a>
        </div>
    </form>
@endsection

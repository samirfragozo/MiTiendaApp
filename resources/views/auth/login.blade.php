@extends('layouts.auth')

@php($crud = 'login')

@section('content')
    <form class="m-login__form m-form" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group m-form__group">
            <input class="form-control m-input{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" placeholder="{{ __('validation.attributes.email') }}" name="email" value="{{ old('email') }}" required autofocus>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group m-form__group">
            <input class="form-control m-input m-login__form-input--last{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" placeholder="{{ __('validation.attributes.password') }}" name="password" required>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="row m-login__form-sub">
            <div class="col m--align-left">
                <label class="m-checkbox m-checkbox--primary">
                    <input type="checkbox" name="remember"{{ old('remember') ? ' checked' : '' }}>{{__('validation.attributes.remember')}}
                    <span></span>
                </label>
            </div>
            <div class="col m--align-right">
                <a href="{{ route('password.request') }}" id="m_login_forget_password" class="m-link">{{ __('base.buttons.forget_password') }}</a>
            </div>
        </div>
        <div class="m-login__form-action">
            <button class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air" type="submit">{{ __('base.buttons.sign_in') }}</button>
        </div>
    </form>
    <div class="m-stack__item m-stack__item--center">
        <div class="m-login__account">
            <span class="m-login__account-msg"> {{ __("Don't have an account yet ?") }}</span>&nbsp;&nbsp;
            <a href="{{ route('register') }}" class="m-link m-link--focus m-login__account-link">{{ __('base.buttons.sign_up') }}</a>
        </div>
    </div>
@endsection

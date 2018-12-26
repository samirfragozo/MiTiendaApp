@extends('layouts.auth')

@php($crud = 'register')

@section('content')
    <form class="m-login__form m-form" action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group m-form__group">
            <input class="form-control m-input{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" placeholder="{{ __('validation.attributes.name') }}" name="name" value="{{ old('name') }}" required autofocus>
            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group m-form__group">
            <input class="form-control m-input{{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text" placeholder="{{ __('validation.attributes.last_name') }}" name="last_name" value="{{ old('last_name') }}" required>
            @if ($errors->has('last_name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group m-form__group">
            <input class="form-control m-input{{ $errors->has('address') ? ' is-invalid' : '' }}" type="text" placeholder="{{ __('validation.attributes.address') }}" name="address" value="{{ old('address') }}" required>
            @if ($errors->has('address'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group m-form__group">
            <input class="form-control m-input{{ $errors->has('neighborhood') ? ' is-invalid' : '' }}" type="text" placeholder="{{ __('validation.attributes.neighborhood') }}" name="neighborhood" value="{{ old('neighborhood') }}" required>
            @if ($errors->has('neighborhood'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('neighborhood') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group m-form__group">
            <input class="form-control m-input{{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" placeholder="{{ __('validation.attributes.phone') }}" name="phone" value="{{ old('phone') }}">
            @if ($errors->has('phone'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group m-form__group">
            <input class="form-control m-input{{ $errors->has('cellphone') ? ' is-invalid' : '' }}" type="text" placeholder="{{ __('validation.attributes.cellphone') }}" name="cellphone" value="{{ old('cellphone') }}">
            @if ($errors->has('cellphone'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('cellphone') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group m-form__group">
            <input class="form-control m-input{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" placeholder="{{ __('validation.attributes.email') }}" name="email" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group m-form__group">
            <input class="form-control m-input{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" placeholder="{{ __('validation.attributes.password') }}" name="password" required>
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group m-form__group">
            <input class="form-control m-input" type="password" placeholder="{{ __('validation.attributes.password_confirmation') }}" name="password_confirmation" required>
        </div>
        <div class="row m-login__form-sub">
            <div class="col m--align-left">
                <label class="m-checkbox m-checkbox--primary">
                    <input type="checkbox" name="remember"{{ old('remember') ? ' checked' : '' }}>{{ __('validation.attributes.agree') }}
                    <span></span>
                </label>
            </div>
        </div>
        <div class="m-login__form-action">
            <button class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air" type="submit">{{ __('base.buttons.submit') }}</button>&nbsp;&nbsp;
            <a href="{{ route('home') }}" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">{{ __('base.buttons.cancel') }}</a>
        </div>
    </form>
@endsection

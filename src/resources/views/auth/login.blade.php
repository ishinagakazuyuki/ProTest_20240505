@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login">
    <div class="login_title">
        <span>Login</span>
    </div>
    <div class="login__content">
        <form class="login-form" action="/login" method="post">
        @csrf
            <div class="login-form__item">
                <img class="login-form_img" src="storage/images/mail.png" alt="" />
                <input class="login-form__input" type="text" name="email" placeholder="Email" value="{{ old('email') }}" >
            </div>
            <div class="login-form__item">
                <img class="login-form_img" src="storage/images/key.png" alt="" />
                <input class="login-form__input" type="password" name="password" placeholder="Password" >
            </div>
            <div class="login-form__button">
                <button class="login-form__button-submit" type="submit">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection
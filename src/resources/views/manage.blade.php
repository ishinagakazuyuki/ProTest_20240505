@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <span>管理画面</span>
    </div>
        <div class="login__content">
        <form class="login-form" action="/create" method="post">
        @csrf
            <div class="login-form__item">
                <img class="login-form_img" src="storage/images/user.png" alt="" />
                <input class="login-form__input" type="text" name="name" placeholder="Username" value="{{ old('name') }}"  >
            </div>
            <div class="login-form__item">
                <img class="login-form_img" src="storage/images/mail.png" alt="" />
                <input class="login-form__input" type="text" name="email" placeholder="Email" value="{{ old('email') }}" >
            </div>
            <div class="login-form__item">
                <img class="login-form_img" src="storage/images/key.png" alt="" />
                <input class="login-form__input" type="password" name="password" placeholder="Password" >
            </div>
            <div class="login-form__button">
                <button class="login-form__button-submit" type="submit">登録</button>
                <input id="name" type="hidden" name="company_register" value=2 >
                <input id="name" type="hidden" name="manage_flg" value='owner' >
            </div>
        </form>
    </div>
</div>
@endsection

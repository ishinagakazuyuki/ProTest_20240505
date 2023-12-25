@extends('layouts.app')

<?php $favorite = 1; ?>

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks">
    <div class="thanks_message">
        <span>会員登録ありがとうございます</span>
    </div>
    <div class="login-guidance">
        <a href="/login" class=login-guidance__link>ログインする</a>
    </div>
</div>
@endsection
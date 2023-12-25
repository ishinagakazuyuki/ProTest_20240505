@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
<div class="todo__alert">
    @if ($errors->any())
    <div  class="todo__alert--danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
<div class="done">
    <div class="done_message">
        <span>ご予約ありがとうございます</span>
    </div>
    <div class="back-guidance">
        <form action="?" method="get">
            <button class='back-guidance__link' type="button" onClick="history.back()">戻る</button>
        </form>
    </div>
</div>
@endsection
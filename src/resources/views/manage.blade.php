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
        <form action="/import" method="post" enctype="multipart/form-data">
        @csrf
            <input type="file" name="csv_file">
            <button type="submit">インポート</button>
            <span class="todo__alert">{{$errors->first('csv_file')}}</span>
        </form>
    </div>
    @if(Session::has('error'))
    <div class="todo__alert">
        <ul>
            @foreach(Session::get('error') as $error)
                @foreach($error as $message)
                    <li>{{ $message }}</li>
                @endforeach
            @endforeach
        </ul>
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
</div>
@endsection

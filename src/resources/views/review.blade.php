@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div class="review-title">
    <span>{{ $shop['name'] }}</span>
</div>
<div class="review-main">
    <form class="review-form" action="/review" method="post">
        @csrf
        <div class="review-form_select">
            <label class="review-form_label">お客様の満足度 </label>
            <div>
                <div class="d-inline">
                    <input type="radio" name="shop_review" value="1">
                    <label for="1">1</label>
                </div>
                <div class="d-inline">
                    <input type="radio" name="shop_review" value="2">
                    <label for="2">2</label>
                </div>
                <div class="d-inline">
                    <input type="radio" name="shop_review" value="3" checked>
                    <label for="3">3</label>
                </div>
                <div class="d-inline">
                    <input type="radio" name="shop_review" value="4">
                    <label for="4">4</label>
                </div>
                <div class="d-inline">
                    <input type="radio" name="shop_review" value="5">
                    <label for="5">5</label>
                </div>
            </div>
        </div>
        <div>
            <span>コメント欄</span><br>
            <textarea class="review-form_textarea" name="comment"></textarea>
        </div>
        <div class="review-form__button">
            <button class="review-form__button-submit" type="submit">登録</button>
            <input type="hidden" name='shop_id' value="{{ $shop['id'] }}">
        </div>
    </form>
</div>
@endsection

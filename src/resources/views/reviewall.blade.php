@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reviewall.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<script src="{{ asset('js/Star_Rating.js') }}"></script>
<script src="{{ asset('js/Comment_Count.js') }}"></script>
<script src="{{ asset('js/Comment_Save.js') }}"></script>
<script src="{{ asset('js/File_Upload.js') }}"></script>
@endsection

@section('content')
<div class="review_main">
    <div class="review_left">
        <div class="review_left-title">
            <span>口コミ情報</span>
        </div>
        <div class="review_left-item">
            <div>
                <img class="review_left-img" src="/storage/images/{{ $shop['image'] }}" alt="" />
            </div>
            <div class="review_left_content">
                <span class="review_left-name">{{ $shop['name'] }}</span>
                <div class="tag">
                    <span class="review_left-tag">#{{ $shop['areas_id'] }}</span>
                    <span class="review_left-tag">#{{ $shop['genres_id'] }}</span>
                </div>
                <div class="review_left-button">
                    <div>
                        <form action="?" method="get">
                            <button class="review_left-button-detail" type="submit" value="get" formaction="{{ route('detail',['shop_id' => $shop['id'] ]) }}">詳しく見る</button>
                            <input type="hidden" name="id" value="{{ $shop['id'] }}" />
                        </form>
                    </div>
                    <div class="review_left-button-favorite">
                        <form action="?" method="post">
                        @csrf
                            <div>
                                @if (empty($favorite[0]))
                                    <?php $fav_flg = 'LightGrey'; ?>
                                @else
                                    <?php $fav_flg = 'Red'; ?>
                                @endif
                                <button class="review_left-button-favorite-item" type="submit" value="post" formaction="/favo_change_mypage"><font color="{{$fav_flg}}">&hearts;</font></button>
                                <input type="hidden" name="id" value="{{ $shop['id'] }}" />
                                <input type="hidden" name="user_id" value="{{ $shop['user_id'] }}" />
                                <input type="hidden" name="fav_flg" value="{{ $shop['fav_flg'] }}" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="detail__comment">
        @foreach ($review as $reviews)
        <div class="detail__comment-edit">
            @if (Auth::check())
            @if ($reviews['user_id'] === $users['id'])
            <div>
                <form action="{{ route('review_edit',['shop_id' => $reviews['shops_id'] ]) }}" method="get">
                    @csrf
                    <button class="list__button-detail" type="submit">口コミを編集</button>
                    <input type="hidden" name="user_review_id" value="{{ $reviews['user_id'] }}" />
                    <input type="hidden" name="id" value="{{ $reviews['shops_id'] }}" />
                </form>
            </div>
            @endif
            @if ($reviews['user_id'] === $users['id'] || $users['auth'] === 'manage')
            <div>
                <form action="{{ route('detail',['shop_id' => $reviews['id'] ]) }}" method="post">
                    @csrf
                    <button class="list__button-detail" type="submit">口コミを削除</button>
                    <input type="hidden" name="user_review_id" value="{{ $reviews['user_id'] }}" />
                    <input type="hidden" name="id" value="{{ $reviews['shops_id'] }}" />
                </form>
            </div>
            @endif
            @endif
        </div>
        <div class="rating rating-{{$reviews['review']}}">
            <span class="star">&#9733;</span>
            <span class="star">&#9733;</span>
            <span class="star">&#9733;</span>
            <span class="star">&#9733;</span>
            <span class="star">&#9733;</span>
        </div>
        <div class="detail__comment-item">
            <span>{{$reviews['comment']}}</span>
        </div>
        @endforeach
    </div>
</div>
@endsection

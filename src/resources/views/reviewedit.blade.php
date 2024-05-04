@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<script src="{{ asset('js/Star_Rating.js') }}"></script>
<script src="{{ asset('js/File_Upload.js') }}"></script>
@endsection

@section('content')
<div class="review_main">
    <div class="review_left">
        <div class="review_left-title">
            <span>今回のご利用はいかがでしたか？</span>
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
    <div class="review_right">
        <form class="review_right-form" action="?" method="post" enctype="multipart/form-data">
            @csrf
            <div class="review_right-select">
                <span class="review-form_label">体験を再評価してください</span>
                <div id="review_star-rating" class="review_star-rating">
                    <i class="far fa-star" data-rating="1" name="shop_review" value="1"></i>
                    <input type="hidden" name="shop_review" value="1">
                    <i class="far fa-star" data-rating="2" name="shop_review" value="2"></i>
                    <input type="hidden" name="shop_review" value="2">
                    <i class="far fa-star" data-rating="3" name="shop_review" value="3"></i>
                    <input type="hidden" name="shop_review" value="3">
                    <i class="far fa-star" data-rating="4" name="shop_review" value="4"></i>
                    <input type="hidden" name="shop_review" value="4">
                    <i class="far fa-star" data-rating="5" name="shop_review" value="5"></i>
                    <input type="hidden" name="shop_review" value="5">
                </div>
            </div>
            <div class="review_right-comment">
                <span class="review-form_label">口コミを投稿</span><br>
                <textarea class="review-form_textarea" id="comment" name="comment">{{$review['comment']}}</textarea>
                <div class="charCount">
                    <div id="charCount">0/400（最高文字数）</div>
                </div>
            </div>
            <div class="review_right-image">
                <span class="review-form_label">画像の追加</span>
                <div id="drop-area" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
                    <label for="fileInput" class="file-label">
                        <input type="file" id="fileInput" name="image" onchange="handleFileSelect(event);" multiple>
                        <span class="drop-text">クリックして追加<br><span>またはドラッグアンドドロップ</span></span>
                    </label>
                </div>
                <span class="error">{{$errors->first('image')}}</span>
            </div>
    </div>
</div>
<div class="review-form__button">
    <button class="review-form__button-submit" type="submit"  formaction="{{ route('review_update',['shop_id' => $shop['id'] ]) }}">口コミを投稿</button>
    <input type="hidden" name='shop_id' value="{{ $shop['id'] }}">
</div>
</form>
@endsection

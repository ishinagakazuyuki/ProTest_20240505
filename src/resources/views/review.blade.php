@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection

<script>
document.addEventListener("DOMContentLoaded", function() {
    const stars = document.querySelectorAll("#review_star-rating .fa-star");

    stars.forEach(function(star) {
        star.addEventListener("click", function() {
            const rating = parseInt(this.getAttribute("data-rating"));

            // クリックされた星の前までの全ての星に青色のスタイルを適用し、それ以降の星には灰色のスタイルを適用する
            stars.forEach(function(s, index) {
                if (index < rating) {
                    s.classList.remove("far");
                    s.classList.add("fas");
                    s.style.color = "blue";
                } else {
                    s.classList.remove("fas");
                    s.classList.add("far");
                    s.style.color = "gray";
                }
            });
        });
    });
});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const textarea = document.getElementById("comment");
    const charCount = document.getElementById("charCount");

    textarea.addEventListener("input", function() {
        const count = textarea.value.length;
        charCount.textContent = count + "/400（最高文字数）"  ;
    });
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const textarea = document.getElementById("comment");

    // ページが読み込まれたときにローカルストレージからデータを取得してテキストエリアに設定する
    const savedValue = localStorage.getItem("textareaValue");
    if (savedValue) {
        textarea.value = savedValue;
    }

    // テキストエリアの値が変更されたときに、その値をローカルストレージに保存する
    textarea.addEventListener("input", function() {
        const textareaValue = this.value;
        localStorage.setItem("textareaValue", textareaValue);
    });
});
</script>

<script>
    function dragOverHandler(event) {
        event.preventDefault();
        event.dataTransfer.dropEffect = 'copy';
        document.getElementById('drop-area').classList.add('dragover');
    }

    function dragLeaveHandler(event) {
        event.preventDefault();
        document.getElementById('drop-area').classList.remove('dragover');
    }

    function dropHandler(event) {
        event.preventDefault();
        document.getElementById('drop-area').classList.remove('dragover');
        var files = event.dataTransfer.files;
        handleFiles(files);
    }

    function handleFileSelect(event) {
        var files = event.target.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        for (var i = 0; i < files.length; i++) {
            uploadFile(files[i]);
        }
    }

    function uploadFile(file) {
        var formData = new FormData();
        formData.append('file', file);

        fetch('/upload', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel CSRF Token
            }
        })
        .then(response => {
            if (response.ok) {
                console.log('File uploaded successfully.');
            } else {
                console.error('File upload failed.');
            }
        })
        .catch(error => {
            console.error('Error uploading file:', error);
        });
    }
</script>

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
                                <button class="review_left-button-favorite-item" type="submit" value="post" formaction="/favo_change_mypage"><font color="Red">&hearts;</font></button>
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
                <span class="review-form_label">体験を評価してください</span>
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
                <textarea class="review-form_textarea" id="comment" name="comment"></textarea>
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
    <button class="review-form__button-submit" type="submit"  formaction="{{ route('review',['shop_id' => $shop['id'] ]) }}">口コミを投稿</button>
    <input type="hidden" name='shop_id' value="{{ $shop['id'] }}">
</div>
</form>
@endsection

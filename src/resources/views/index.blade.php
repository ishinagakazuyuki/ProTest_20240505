@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('title')
<div class="header-search">
    <div class="header-search__sub">
        <form id="search" action="/search" method="get">
            <select class="header-search__item" name="area" id="area">
                <?php
                $areaList = array(
                    "All area",
                    "東京都",
                    "大阪府",
                    "福岡県",
                );
                foreach($areaList as $value){
                    if($value === $area){
                    echo "<option value='$value' selected>".$value."</option>";
                    }else{
                    echo "<option value='$value'>".$value."</option>";
                    }
                }
                ?>
            </select>
            <script>
                document.getElementById('area').addEventListener('change', function() {
                    document.getElementById('search').submit();
                });
            </script>
            <select class="header-search__item" name="genre" id="genre">
                <?php
                $genreList = array(
                    "All genre",
                    "居酒屋",
                    "寿司",
                    "焼肉",
                    "イタリアン",
                    "ラーメン",
                );
                foreach($genreList as $value){
                    if($value === $genre){
                    echo "<option value='$value' selected>".$value."</option>";
                    }else{
                    echo "<option value='$value'>".$value."</option>";
                    }
                }
                ?>
            </select>
            <script>
                document.getElementById('genre').addEventListener('change', function() {
                    document.getElementById('search').submit();
                });
            </script>
            <svg class="header-search__icon" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
            <input class="header-search__text" id="text" name="text" type="search" placeholder="Search...">
            <script>
                document.getElementById('text').addEventListener('change', function() {
                    document.getElementById('search').submit();
                });
            </script>
        </form>
    </div>
</div>
@endsection

@section('content')
<div class="list">
    @foreach ($shop as $shops)
        @if (Auth::guest())
        <?php
        $shops = [
            'id' => $shops['id'],
            'user_id' => 'no',
            'name' => $shops['name'],
            'areas_id'=> $shops['areas_id'],
            'genres_id'=> $shops['genres_id'],
            'image' => $shops['image'],
        
        ];
        $fav_access = 'disabled';
        ?>
        @endif
    <div class="list__item">
        <div>
            <img class="list__img" src="storage/images/{{ $shops['image'] }}" alt="" />
        </div>
        <div class="list__content">
            <span class="list_name">{{ $shops['name'] }}</span>
            <div class="tag">
                <span class="list__tag">#{{ $shops['areas_id'] }}</span>
                <span class="list__tag">#{{ $shops['genres_id'] }}</span>
            </div>
            <div class="list__button">
                <div>
                    <form action="?" method="get">
                        <button class="list__button-detail" type="submit" value="get" formaction="{{ route('detail',['shop_id' => $shops['id'] ]) }}">詳しく見る</button>
                        <input type="hidden" name="id" value="{{ $shops['id'] }}" />
                    </form>
                </div>
                @if (!empty($favorite[0]))
                    <?php
                    $fav_flg = [
                        'fav_flg'=> 'LightGrey',
                    ];
                    ?>
                @foreach ($favorite as $favorites)
                    @if ($shops['id'] === $favorites['shops_id'])
                        <?php
                        $fav_flg = [
                            'fav_flg'=> 'Red',
                        ];
                        ?>
                    @endif
                @endforeach
                <div class="list__button-favorite">
                    <form action="?" method="post">
                    @csrf
                        <div>
                            <button class="list__button-favorite-item" type="submit" value="post" formaction="/favo_change" {{$fav_access}}><font color="{{$fav_flg['fav_flg']}}">&hearts;</font></button>
                            <input type="hidden" name="id" value="{{ $shops['id'] }}" />
                            <input type="hidden" name="user_id" value="{{ $user_id['id'] }}" />
                        </div>
                    </form>
                </div>
                @else
                <div class="list__button-favorite">
                    <form action="?" method="post">
                    @csrf
                        <div>
                            <button class="list__button-favorite-item" type="submit" value="post" formaction="/favo_change" {{$fav_access}}><font color="LightGrey">&hearts;</font></button>
                            @if (Auth::check())
                            <input type="hidden" name="id" value="{{ $shops['id'] }}" />
                            <input type="hidden" name="user_id" value="{{ $user_id['id'] }}" />
                            @endif
                        </div>
                    </form>
                </div>
                @endif                
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
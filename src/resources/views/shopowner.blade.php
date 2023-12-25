@extends('layouts.app')
@stack('scripts')
@section('css')
<link rel="stylesheet" href="{{ asset('css/shopowner.css') }}">
@endsection

@section('content')
<div class="shopowner_main">
    <div class="shop_content">
        <form action="/update" method="post" enctype="multipart/form-data">
        @csrf
            <div>
                <div class='shop_title'>
                    <input name="name" class="shop_title-name" value="{{ $shop['name'] }}">
                </div>
                <div>
                    <img name="img" class="shop_img" src="../storage/images/{{ $shop['name'] }}.jpg" alt="" />
                    <input name="img" type="file">
                </div>
                <div class="shop_tag">
                    <span>#</span>
                    <input name="area" class="shop_tag-item" value="{{ $shop['area'] }}"><br>
                    <span>#</span>
                    <input name="genre" class="shop_tag-item" value="{{ $shop['genre'] }}">
                </div>
                <div class="shop_overview">
                    <textarea name="overview" class="shop_overview-item">{{ $shop['overview'] }}</textarea>
                </div>
                <div>
                    <button class="login-form__button-submit" type="submit">登録</button>
                    <input type="hidden" name='id' value="{{ $shop['id'] }}">
                </div>
            </div>
        </form>
    </div>
    <div class="mypage_reserve">
        <div class="mypage_reserve-title">
            <span>予約状況</span>
        </div>
        <div class="mypage_reserve-detail">
        <?php $count = 1; ?>
        @if(!empty($reserve))
            @foreach ($reserve as $reserves)
                @foreach ($user as $users)
                    @if($users['id'] == $reserves['user_id'])
                        <div class="mypage_reserve-detail-item">
                            <form action="?" method="?">
                            @csrf
                                <table class="mypage_reserve-detail-table1">
                                    <tr>
                                        <td class="mypage_reserve-item-name1"><img class="mypage_reserve_img" src="storage/images/clock.png" alt="" /></td>
                                        <td class="mypage_reserve-item-name2"><span>{{ $users['name'] }}様{{ $count}}</span></td>
                                    </tr>
                                </table>
                                <table class="mypage_reserve-detail-table2">
                                    <tr>
                                        <td class="mypage_reserve-item1">Shop</td>
                                        <td class="mypage_reserve-item2">
                                            <span name="reserve_name">{{ $reserves['name'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="mypage_reserve-item1">Date</td>
                                        <td class="mypage_reserve-item2">
                                            <span name="reserve_date">{{ $reserves['date'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="mypage_reserve-item1">Time</td>
                                        <td class="mypage_reserve-item2">
                                            <span name="reserve_time">{{ $reserves['time'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="mypage_reserve-item1">Number</td>
                                        <td class="mypage_reserve-item2">
                                            <span name="reserve_number">{{ $reserves['number'] }}人</span>
                                        </td>
                                    </tr>
                                </table>
                                <div class="mypage_reserve-button">
                                    <button class="mypage_reserve-submit" type="submit" value="post" formaction="/send_mail">予約日お知らせメールを送信する
                                    </button>
                                    <input type="hidden" name='user_name' value="{{ $users['name'] }}">
                                    <input type="hidden" name='reserve_name' value="{{ $reserves['name'] }}">
                                    <input type="hidden" name='reserve_date' value="{{ $reserves['date'] }}">
                                    <input type="hidden" name='reserve_time' value="{{ $reserves['time'] }}">
                                    <input type="hidden" name='reserve_number' value="{{ $reserves['number'] }}">
                                </div>
                            </form>
                        </div>
                    @endif
                    <?php $count = $count + 1; ?>
                @endforeach
            @endforeach
        @endif
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
@endsection

@section('content')
<div class="mypage_name">
    <div class="mypage_name-item"></div>
    <div>
        <span>{{ $users['name'] }}さん</span>
    </div>
</div>
<div class="mypage_main">
    <div class="mypage_reserve">
        <div class="mypage_reserve-title">
            <span>予約状況</span>
        </div>
        <div class="mypage_reserve-detail">
        <?php $count = 1; ?>
        @if(!empty($reserve))
        @foreach ($reserve as $reserves)
            <div class="mypage_reserve-detail-item">
                <form action="?" method="?">
                @csrf
                <table class="mypage_reserve-detail-table1">
                    <tr>
                        <td class="mypage_reserve-item-name1"><img class="mypage_reserve_img" src="storage/images/clock.png" alt="" /></td>
                        <td class="mypage_reserve-item-name2"><span>予約{{ $count }}</span></td>
                        <td class="mypage_reserve-item-name3">
                            <button class="mypage_reserve-item-name3-button" value="get" formaction="{{ route('payment.payment') }}">お支払い</button>
                        </td>
                        <td class="mypage_reserve-item-name4">
                            <button class="mypage_reserve-item-button" value="post" formaction="/reserve_delete"></button>
                            <input type="hidden" name='reserve_id' value="{{ $reserves['id'] }}">
                        </td>
                    </tr>
                </table>
                <table class="mypage_reserve-detail-table2">
                    <tr>
                        <td class="mypage_reserve-item1">Shop</td>
                        <td class="mypage_reserve-item2"><span name="name">{{ $reserves['name'] }}</span></td>
                    </tr>
                    <tr>
                        <td class="mypage_reserve-item1">Date</td>
                        <td class="mypage_reserve-item2">
                            <input id="reserve_date" class="mypage_reserve-input" name="date" type="date" value="{{ $reserves['date'] }}">
                        </td>
                    </tr>
                    <tr>
                        <td class="mypage_reserve-item1">Time</td>
                        <td class="mypage_reserve-item2">
                            <?php $time = date('H:i',strtotime($reserves['time'])); ?>
                            <select class="mypage_reserve-input" name="time" id="reserve_time" style="">
                                <option selected="" value="{{ $time }}">{{ $time }}</option>
                                    @for($i = 0; $i <= 23; $i++)
                                        @for($j = 0; $j <= 5; $j++)
                                            @if($i <= 9)
                                                <option label="0{{$i}}:{{$j}}0" value="0{{$i}}:{{$j}}0">0{{$i}}:{{$j}}0</option>
                                            @else
                                                <option label="{{$i}}:{{$j}}0" value="{{$i}}:{{$j}}0">{{$i}}:{{$j}}0</option>
                                            @endif
                                        @endfor
                                    @endfor
                            </select>
                        </td>
                    </tr>
                        <td class="mypage_reserve-item1">Number</td>
                        <td class="mypage_reserve-item2">
                            <select class="mypage_reserve-input" name="number" id="reserve_number" style="">
                                <option value="{{ $reserves['number'] }}" selected="">{{ $reserves['number'] }}人</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option label="{{$i}}人" value="{{$i}}"></option>
                                    @endfor
                            </select>
                        </td>
                    </tr>
                </table>
                <div class="mypage_reserve-button">
                    <button class="mypage_reserve-submit" type="submit" value="post" formaction="/reserve_change">予約内容を修正する</button>
                    <input type="hidden" name='id' value="{{ $reserves['id'] }}">
                </div>
                </form>
                <?php $count = $count + 1; ?>
            </div>
        @endforeach
        @endif
        </div>
    </div>

    <div class="mypage_favorite">
        <div class="mypage_favorite-title">
            <span>お気に入り店舗</span>
        </div>
        <div class="mypage_favorite-list">
        @foreach ($shop as $shops)
            <div class="mypage_favorite-item">
                <div>
                    <img class="mypage_favorite-img" src="../storage/images/{{ $shops['image'] }}" alt="" />
                </div>
                <div class="mypage_favorite_content">
                    <span class="mypage_favorite_name">{{ $shops['name'] }}</span>
                    <div class="tag">
                        <span class="mypage_favorite_tag">#{{ $shops['areas_id'] }}</span>
                        <span class="mypage_favorite_tag">#{{ $shops['genres_id'] }}</span>
                    </div>
                    <div class="mypage_favorite_button">
                        <div>
                            <form action="?" method="get">
                                <button class="mypage_favorite_button-detail" type="submit" value="get" formaction="{{ route('detail',['shop_id' => $shops['id'] ]) }}">詳しく見る</button>
                                <input type="hidden" name="id" value="{{ $shops['id'] }}" />
                            </form>
                        </div>
                        <div class="mypage_favorite_button-favorite">
                            <form action="?" method="post">
                            @csrf
                                <div>
                                    <button class="mypage_favorite_button-favorite-item" type="submit" value="post" formaction="/favo_change_mypage"><font color="Red">&hearts;</font></button>
                                    <input type="hidden" name="id" value="{{ $shops['id'] }}" />
                                    <input type="hidden" name="user_id" value="{{ $shops['user_id'] }}" />
                                    <input type="hidden" name="fav_flg" value="{{ $shops['fav_flg'] }}" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>
@endsection
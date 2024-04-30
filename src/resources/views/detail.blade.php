@extends('layouts.app')
@stack('scripts')
@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail__content">
    <div class='detail__title'>
        <button class='detail_title-back' type="button" onClick="history.go({{ $count }})"><</button>
        <span class="detail_title-name">{{ $shop['name'] }}</span>
    </div>
    <div>
        <img class="detail__img" src="../storage/images/{{ $shop['image'] }}" alt="" />
    </div>
    <div class="detail__tag">
        <span>#{{ $shop['area'] }}</span>
        <span>#{{ $shop['genre'] }}</span>
    </div>
    <div class="detail__overview">
        <span>#{{ $shop['overview'] }}</span>
    </div>
</div>

<div class="reserve_content">
    <div class="reserve_title">
        <span>予約</span>
    </div>
    <div>
        <form id="reserve" action="{{ route('detail',['shop_id' => $shop['id'] ]) }}" method="post">
            @csrf
            <div class="reserve_form-item">
                <input id="reserve_date" name="date" class="reserve_date" type="date" value="<?php echo date('Y-m-j');?>">
            </div>
            <script>
                document.getElementById('reserve_date').addEventListener('input', function() {
                    var inputValue = this.value;
                    document.getElementById('reserve_date_Display').innerHTML = inputValue;
                });
            </script>
            <div class="reserve_form-item">
                <select class="reserve_time" name="time" id="reserve_time" style="">
                    <option selected="" value="--時間--">--時間--</option>
                    @for($i = 0; $i <= 23; $i++)
                        @for($j = 0; $j <= 5; $j++)
                            @if($i <= 9)
                                <option label="0{{$i}}:{{$j}}0" value="0{{$i}}:{{$j}}0">{{$i}}:{{$j}}0</option>
                            @else
                                <option label="{{$i}}:{{$j}}0" value="{{$i}}:{{$j}}0">{{$i}}:{{$j}}0</option>
                            @endif
                        @endfor
                    @endfor
                </select>
            </div>
            <script>
                document.getElementById('reserve_time').addEventListener('change', function() {
                    var selectedOption = this.value;
                    document.getElementById('reserve_time_Display').innerHTML = selectedOption;
                });
            </script>
            <div class="reserve_form-item">
                <select class="reserve_number" name="number" id="reserve_number" style="">
                    <option value="1" selected="">1人</option>
                    @for($i = 2; $i <= 10; $i++)
                        <option label="{{$i}}人" value="{{$i}}"></option>
                    @endfor
                </select>
            </div>
            <script>
                document.getElementById('reserve_number').addEventListener('change', function() {
                    var selectedOption = this.value;
                    document.getElementById('reserve_number_Display').innerHTML = selectedOption;
                });
            </script>
            <div class="reserve_detail">
                <table>
                    <tr>
                        <td class="reserve_detail-item">Shop</td>
                        <td><span>{{ $shop['name'] }}</span></td>
                    </tr>
                    <tr>
                        <td class="reserve_detail-item">Date</td>
                        <td><span id="reserve_date_Display"></span></td>
                    </tr>
                    <tr>
                        <td class="reserve_detail-item">Time</td>
                        <td><span id="reserve_time_Display"></span></td>
                    </tr>
                        <td class="reserve_detail-item">Number</td>
                        <td><span id="reserve_number_Display"></span><span>人</span></td>
                    </tr>
                </table>
            </div>
            <div class="reserve_button">
                <button class="reserve_button-submit" type="submit">予約する</button>
                <input type="hidden" name="id" value="{{ $shop['id'] }}" />
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var inputValue = document.getElementById('reserve_date').value;
        document.getElementById('reserve_date_Display').innerHTML = inputValue;

        var selectedOption = document.getElementById('reserve_time').value;
        document.getElementById('reserve_time_Display').innerHTML = selectedOption;

        var selectedOption = document.getElementById('reserve_number').value;
        document.getElementById('reserve_number_Display').innerHTML = selectedOption;
    });
</script>
@endsection
@extends('layouts.app')
@stack('scripts')
@section('css')
<link rel="stylesheet" href="{{ asset('css/check.css') }}">
@endsection

@section('content')
<div class="reserve_content">
    <div class="reserve_title">
        <span>予約情報</span>
    </div>
    <div class="reserve_detail">
            <table>
                <tr class="reserve_detail-item">
                    <td class="reserve_detail-item">予約者名</td>
                    <td><span>{{ $user['name'] }}</span></td>
                </tr>
                <tr class="reserve_detail-item">
                    <td>予約店名</td>
                    <td><span>{{ $shop['name'] }}</span></td>
                </tr>
                <tr class="reserve_detail-item">
                    <td>予約日時</td>
                    <td><span>{{ $shop['date'] }}　{{ $shop['time'] }}</span></td>
                </tr>
                <tr class="reserve_detail-item">
                    <td>予約人数</td>
                    <td><span>{{ $shop['number'] }}</span></td>
                </tr>
            </table>
        </div>
</div>
@endsection
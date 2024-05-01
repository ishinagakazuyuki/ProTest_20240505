<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendMail;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Http\Requests\ReserveRequest;

class ReserveController extends Controller
{
    public function reserve(ReserveRequest $request){
        $users = Auth::user()->only(['id']);
        $user_id = [
            'user_id' => $users['id']
        ];
        $shops_id = [
            'shops_id' => $request['id']
        ];
        $number = [
            'number' => $request['number']
        ];
        $date = [
            'date' => $request['date']
        ];
        $time = [
            'time' => $request['time']
        ];
        $datetime = [
            'datetime' => $request['date']." ".$request['time']
        ];
        $reservation = array_merge($user_id,$shops_id,$number,$date,$time,$datetime);
        reservation::create($reservation);
        $favorite = 2;
        $shop = favorite::join('shops','favorites.shops_id','shops.id')->where('user_id','=',$users['id'])
            ->orderBy('shops.id', 'asc')->get();
        $shop = shop::where('id','=',$request['id'])->get();
        $count = -2;
        return view('done', compact('shop','favorite','count'));
    }

    public function reserve_delete(Request $request){
        $users = Auth::user();
        reservation::where('id','=',$request['reserve_id'])->delete();
        $reserve = shop::join('reservations','shops.id','reservations.shops_id')->where('user_id','=',$users['id'])
                    ->orderBy('reservations.datetime', 'asc')->get();
        $shop = favorite::join('shops','favorites.shops_id','shops.id')->where('user_id','=',$users['id'])
            ->orderBy('shops.id', 'asc')->get();
        $areadata = area::get();
        $genredata = genre::get();
        foreach ($shop as $shops){
            foreach($areadata as $areadatas){
                if($shops['areas_id'] === $areadatas['id']){
                    $shops['areas_id'] = $areadatas['area'];
                }
            }
            foreach($genredata as $genredatas){
                if($shops['genres_id'] === $genredatas['id']){
                    $shops['genres_id'] = $genredatas['genre'];
                }
            }
        }
        return view('mypage', compact('users','reserve','shop'));
    }

    public function reserve_change(ReserveRequest $request){
        $users = Auth::user();
        reservation::where('id', '=',  $request['id'])->first()->update([
            'number' => $request['number'],
            'date' => $request['date'],
            'time' => $request['time'],
            'datetime' => $request['date']." ".$request['time']
        ]);
        $reserve = shop::join('reservations','shops.id','reservations.shops_id')->where('user_id','=',$users['id'])
                    ->orderBy('reservations.datetime', 'asc')->get();
        $shop = favorite::join('shops','favorites.shops_id','shops.id')->where('user_id','=',$users['id'])
            ->orderBy('shops.id', 'asc')->get();
        $areadata = area::get();
        $genredata = genre::get();
        foreach ($shop as $shops){
            foreach($areadata as $areadatas){
                if($shops['areas_id'] === $areadatas['id']){
                    $shops['areas_id'] = $areadatas['area'];
                }
            }
            foreach($genredata as $genredatas){
                if($shops['genres_id'] === $genredatas['id']){
                    $shops['genres_id'] = $genredatas['genre'];
                }
            }
        }
        return view('mypage', compact('users','reserve','shop'));
    }
}

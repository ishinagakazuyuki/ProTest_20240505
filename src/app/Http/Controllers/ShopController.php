<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Owner;
use App\Models\Review;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Http\Requests\ReserveRequest;
use App\Http\Requests\CreateRequest;

class ShopController extends Controller
{
    public function search(Request $request){
        $user_id = Auth::user();
        $shop = shop::get();
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
        if($request['area'] === 'All area'){
            if($request['genre'] === 'All genre'){
                if (!empty($request['text'])) {
                    $shop = $shop->where('name','=',$request['text']);
                }
                $area = "";
                $genre = "";
            }else{
                if (!empty($request['text'])) {
                    $shop = $shop->where('genres_id','=',$request['genre'])->where('name','=',$request['text']);
                } else {
                    $shop = $shop->where('genres_id','=',$request['genre']);
                }
                $area = "";
                $genre = $request['genre'];
            }
        }else{
            if($request['genre'] === 'All genre'){
                if (!empty($request['text'])) {
                    $shop = $shop->where('areas_id','=',$request['area'])->where('name','=',$request['text']);
                } else {
                    $shop = $shop->where('areas_id','=',$request['area']);
                }
                $area = $request['area'];
                $genre = "";
            }else{
                if (!empty($request['text'])) {
                    $shop = $shop->where('areas_id','=',$request['area'])->where('genres_id','=',$request['genre'])->where('name','=',$request['text']);
                } else {
                    $shop = $shop->where('areas_id','=',$request['area'])->where('genres_id','=',$request['genre']);
                }
                $area = $request['area'];
                $genre = $request['genre'];
            }
        }
        if(!empty($user_id)){
            $favorite = favorite::where('user_id','=',$user_id['id'])->get();
        } else {
            $favorite = null;
        }
        $fav_access = '';
        return view('index', compact('user_id','shop','favorite','area','genre','fav_access'));
    }

    public function detail(Request $request){
        $user_id = Auth::user();
        $shop = shop::join('areas','shops.areas_id','areas.id')->join('genres','shops.genres_id','genres.id')
                ->where('shops.id','=',$request['id'])->first();
        $count = -1;
        return view('detail', compact('shop','count'));
    }

    public function mypage(Request $request){
        $users = Auth::user();
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

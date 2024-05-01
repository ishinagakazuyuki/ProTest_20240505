<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;

class FavoriteController extends Controller
{
    public function favo_change(Request $request){
        $favo_check = favorite::where('user_id','=',$request['user_id'])->where('shops_id','=',$request['id'])->first();
        if (empty($favo_check)){
            favorite::create([
                'user_id' => $request['user_id'],
                'shops_id' => $request['id'],
            ]);            
        } else {
            $favo_check->delete();
        }
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
        $favorite = favorite::where('user_id','=',$user_id['id'])->get();
        $area = "";
        $genre = "";
        $fav_access = '';
        return view('index', compact('user_id','shop','favorite','area','genre','fav_access'));
    }

    public function favo_change_mypage(Request $request){
        $favo_check = favorite::where('user_id','=',$request['user_id'])->where('shops_id','=',$request['id'])->first();
        if (empty($favo_check)){
            favorite::create([
                'user_id' => $request['user_id'],
                'shops_id' => $request['id'],
            ]);            
        } else {
            $favo_check->delete();
        }
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

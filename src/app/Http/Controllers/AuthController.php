<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\shop;
use App\Models\favorite;
use App\Models\reservation;

class AuthController extends Controller
{
    public function list(Request $request){
        $user_id = Auth::user();
        $shop = shop::get();
        $shop_id = shop::select('id')->get();
        if(empty($user_id)){
            $favorite = 1;
        }else{
            $favorite = 2;
            $shop = favorite::join('shops','favorites.shops_id','shops.id')->where('user_id','=',$user_id['id'])
                ->orderBy('shops.id', 'asc')->get();
        }
        $area = "";
        $genre = "";
        return view('list', compact('shop','favorite','area','genre'));
    }
}

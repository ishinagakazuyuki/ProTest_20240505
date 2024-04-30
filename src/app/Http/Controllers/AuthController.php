<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;

class AuthController extends Controller
{
    public function index(Request $request){
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
        $area = "";
        $genre = "";
        return view('index', compact('user_id','shop','area','genre'));
    }
}

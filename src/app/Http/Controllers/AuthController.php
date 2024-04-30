<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\genre;
use App\Models\Favorite;

class AuthController extends Controller
{
    public function index(Request $request){
        $user_id = Auth::user();
        $shop = shop::join('areas','shops.areas_id','areas.id')->join('genres','shops.genres_id','genres.id')->get();
        $area = "";
        $genre = "";
        return view('index', compact('user_id','shop','area','genre'));
    }
}

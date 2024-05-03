<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Review;

class ReviewController extends Controller
{
    public function review(Request $request){
        $users = Auth::user();
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
        $shop = $shop->where('id','=',$request['id'])->first();
        $favorite = favorite::where('user_id','=',$users['id'])->where('shops_id','=',$request['id'])->first();
        return view('review', compact('shop','favorite'));
    }

    public function reviews(Request $request){
        $user_id = Auth::user();
        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $filename = $user_id['id']."_".$filename;
        $request->file('image')->storeAs('public/images', $filename);
        review::create([
            'user_id' => $user_id['id'],
            'shops_id' => $request['shop_id'],
            'review' => $request['shop_review'],
            'comment' => $request['comment'],
            'review_image' => $filename,
        ]);
        $shop = shop::where('id','=',$request['shop_id'])->first();
        return view('review', compact('shop'));
    }
}

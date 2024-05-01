<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Review;

class ReviewController extends Controller
{
    public function review(Request $request){
        $shop = shop::where('id','=',$request['shop_id'])->first();
        $favorite = 2;
        return view('review', compact('shop','favorite'));
    }

    public function reviews(Request $request){
        $user_id = Auth::user();
        review::create([
            'user_id' => $user_id['id'],
            'shops_id' => $request['shop_id'],
            'review' => $request['shop_review'],
            'comment' => $request['comment'],
        ]);
        $shop = shop::where('id','=',$request['shop_id'])->first();
        return view('review', compact('shop'));
    }
}

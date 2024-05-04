<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;

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

    public function reviews(ReviewRequest $request){
        $users = Auth::user();
        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $filename = $users['id']."_".$filename;
        $request->file('image')->storeAs('public/images', $filename);
        review::create([
            'user_id' => $users['id'],
            'shops_id' => $request['shop_id'],
            'review' => $request['shop_review'],
            'comment' => $request['comment'],
            'review_image' => $filename,
        ]);
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
        $shop = $shop->where('id','=',$request['shop_id'])->first();
        $favorite = favorite::where('user_id','=',$users['id'])->where('shops_id','=',$request['shop_id'])->first();
        return view('review', compact('shop','favorite'));
    }

    public function review_delete(Request $request){
        review::where('id','=',$request['user_review_id'])->delete();

        $user_id = Auth::user();
        $shop = shop::join('areas','shops.areas_id','areas.id')->join('genres','shops.genres_id','genres.id')
                ->where('shops.id','=',$request['id'])->first();
        $review = review::where('shops_id','=',$request['id'])->orderBy('shops_id', 'asc')->first();
        if(!empty($user_id)){
            $user_review = review::where('user_id','=',$user_id['id'])->where('shops_id','=',$request['id'])->first();
        } else {
            $user_review = null;
        }
        if(empty($user_id)){
            $review_del = 0;
            $review_edit = 0;
        } elseif(empty($review)){
            $review_del = 0;
            $review_edit = 0;
        } elseif(!empty($review)){        
            if ($user_id['id'] === $review['user_id']){
                $review_del = 1;
                $review_edit = 1;
            } elseif ($user_id['auth'] === "manage") {
                $review_del = 1;
                $review_edit = 0;
            }
        }
        $count = -1;
        return view('detail', compact('shop','count','review','user_review','review_del','review_edit'));
    }

    public function review_edit(Request $request){
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
        $review = review::where('shops_id','=',$request['id'])->where('user_id','=',$users['id'])->first();
        return view('reviewedit', compact('shop','favorite','review'));
    }

    public function review_update(ReviewRequest $request){
        $users = Auth::user();
        $file = $request->file('image');
        $filename = $file->getClientOriginalName();
        $filename = $users['id']."_".$filename;
        $request->file('image')->storeAs('public/images', $filename);
        review::where('shops_id','=',$request['shop_id'])->where('user_id','=',$users['id'])->first()->update([
            'review' => $request['shop_review'],
            'comment' => $request['comment'],
            'review_image' => $filename,
        ]);
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
        $shop = $shop->where('id','=',$request['shop_id'])->first();
        $favorite = favorite::where('user_id','=',$users['id'])->where('shops_id','=',$request['shop_id'])->first();
        $review = review::where('shops_id','=',$request['shop_id'])->where('user_id','=',$users['id'])->first();
        return view('reviewedit', compact('shop','favorite','review'));
    }
}

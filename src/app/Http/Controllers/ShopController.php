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
    public function thanks(Request $request){
        return view('thanks');
    }

    public function favo_change(Request $request){
        if($request['fav_flg'] === 'Red'){
            $fav_flg = 'LightGrey';
        }elseif($request['fav_flg'] === 'LightGrey'){
            $fav_flg = 'Red';
        }
        favorite::where('shops_id','=',$request['id'])->where('user_id','=',$request['user_id'])->first()->update([
            'fav_flg' => $fav_flg,
        ]);
        $user_id = Auth::user();
        $favorite = 2;
        $shop = favorite::join('shops','favorites.shops_id','shops.id')->where('user_id','=',$user_id['id'])
                ->orderBy('shops.id', 'asc')->get();
        $area = "";
        $genre = "";
        return view('list', compact('shop','favorite','area','genre'));
    }

    public function search(Request $request){
        $user_id = Auth::user();
        if(empty($user_id)){
            $favorite = 1;
            if($request['area'] === 'All area'){
                if($request['genre'] === 'All genre'){
                    $shop = shop::TextSearch($request->text)->get();
                    $area = "";
                    $genre = "";
                }else{
                    $shop = shop::where('genre','=',$request['genre'])->TextSearch($request->text)->get();
                    $area = "";
                    $genre = $request['genre'];
                }
            }else{
                if($request['genre'] === 'All genre'){
                    $shop = shop::where('area','=',$request['area'])->TextSearch($request->text)->get();
                    $area = $request['area'];
                    $genre = "";
                }else{
                    $shop = shop::where('area','=',$request['area'])->where('genre','=',$request['genre'])->TextSearch($request->text)->get();
                    $area = $request['area'];
                    $genre = $request['genre'];
                }
            }
        }else{
            $favorite = 2;
            if($request['area'] === 'All area'){
                if($request['genre'] === 'All genre'){
                    $shop = favorite::join('shops','favorites.shops_id','shops.id')->where('user_id','=',$user_id['id'])
                        ->TextSearch($request->text)->orderBy('shops.id', 'asc')->get();
                    $area = "";
                    $genre = "";
                }else{
                    $shop = favorite::join('shops','favorites.shops_id','shops.id')->where('user_id','=',$user_id['id'])
                        ->where('genre','=',$request['genre'])->TextSearch($request->text)->orderBy('shops.id', 'asc')->get();
                    $area = "";
                    $genre = $request['genre'];
                }
            }else{
                if($request['genre'] === 'All genre'){
                    $shop = favorite::join('shops','favorites.shops_id','shops.id')->where('user_id','=',$user_id['id'])
                        ->where('area','=',$request['area'])->TextSearch($request->text)->orderBy('shops.id', 'asc')->get();
                    $area = $request['area'];
                    $genre = "";
                }else{
                    $shop = favorite::join('shops','favorites.shops_id','shops.id')->where('user_id','=',$user_id['id'])
                        ->where('area','=',$request['area'])->where('genre','=',$request['genre'])->TextSearch($request->text)->orderBy('shops.id', 'asc')->get();
                    $area = $request['area'];
                    $genre = $request['genre'];
                }
            }
        }
        return view('list', compact('shop','favorite','area','genre'));
    }

    public function detail(Request $request){
        $user_id = Auth::user();
        $shop = shop::join('areas','shops.areas_id','areas.id')->join('genres','shops.genres_id','genres.id')
                ->where('shops.id','=',$request['id'])->first();
        $count = -1;
        return view('detail', compact('shop','count'));
    }

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

    public function mypage(Request $request){
        $users = Auth::user();
        $reserve = shop::join('reservations','shops.id','reservations.shops_id')->where('user_id','=',$users['id'])
                    ->orderBy('reservations.datetime', 'asc')->get();
        $favorite = favorite::join('shops','favorites.shops_id','shops.id')->where('user_id','=',$users['id'])
            ->where('fav_flg','=','Red')->orderBy('shops.id', 'asc')->get();
        return view('mypage', compact('users','reserve','favorite'));
    }

    public function reserve_delete(Request $request){
        $users = Auth::user();
        reservation::where('id','=',$request['reserve_id'])->delete();
        $reserve = shop::join('reservations','shops.id','reservations.shops_id')->where('user_id','=',$users['id'])
                    ->orderBy('reservations.datetime', 'asc')->get();
        $favorite = favorite::join('shops','favorites.shops_id','shops.id')->where('user_id','=',$users['id'])
            ->where('fav_flg','=','Red')->orderBy('shops.id', 'asc')->get();
        return view('mypage', compact('users','reserve','favorite'));
    }

    public function favo_change_mypage(Request $request){
        if($request['fav_flg'] === 'Red'){
            $fav_flg = 'LightGrey';
        }elseif($request['fav_flg'] === 'LightGrey'){
            $fav_flg = 'Red';
        }
        favorite::where('shops_id','=',$request['id'])->where('user_id','=',$request['user_id'])->first()->update([
            'fav_flg' => $fav_flg,
        ]);
        $users = Auth::user();
        $reserve = shop::join('reservations','shops.id','reservations.shops_id')->where('user_id','=',$users['id'])
            ->orderBy('reservations.datetime', 'asc')->get();
        $favorite = favorite::join('shops','favorites.shops_id','shops.id')->where('user_id','=',$users['id'])
            ->where('fav_flg','=','Red')->orderBy('shops.id', 'asc')->get();
        return view('mypage', compact('users','reserve','favorite'));
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
        $favorite = favorite::join('shops','favorites.shops_id','shops.id')->where('user_id','=',$users['id'])
            ->where('fav_flg','=','Red')->orderBy('shops.id', 'asc')->get();
        return view('mypage', compact('users','reserve','favorite'));
    }

    public function payment(Request $request){
        $favorite = 2;
        return view('payment', compact('favorite'));
    }

    public function payments(Request $request){
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));

        try {
            \Stripe\Charge::create([
                'source' => $request->stripeToken,
                'amount' => 1000,
                'currency' => 'jpy',
            ]);
        } catch (Exception $e) {
            return back()->with('flash_alert', '決済に失敗しました！('. $e->getMessage() . ')');
        }
        return back()->with('status', '決済が完了しました！');
    }

    public function manage(Request $request){
        $favorite = 2;
        return view('manage', compact('favorite'));
    }

    public function create(CreateRequest $request){
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'auth' => 'owner'
        ]);
        $user = user::where('name','=',$request['name'])->first();
        $user->sendEmailVerificationNotification();
        return view('manage');
    }

    public function owner(Request $request){
        $user_id = Auth::user();
        $favorite = 2;
        $shop = owner::join('shops','owners.shops_id','shops.id')->where('user_id','=',$user_id['id'])->first();
        if(empty($shop)){
            $shop = [
                'id' => null,
                'name' => '店名を入力してください',
                'area' => '都道府県',
                'genre' => 'ジャンル',
                'overview' => '店の説明を入力してください',
            ];
            $reserve = null;
        }else{
            $reserve = reservation::join('shops','reservations.shops_id','shops.id')->where('shops_id','=',$shop['shops_id'])->get();
        }
        $user = user::get();
        return view('shopowner', compact('shop','favorite','reserve','user'));
    }

    public function update(Request $request){
        $user_id = Auth::user();
        $favorite = 2;
        if(empty($request['id'])){
            shop::create([
                'name' => $request['name'],
                'area' => $request['area'],
                'genre' => $request['genre'],
                'overview' => $request['overview'],
            ]);
            $shop_id = shop::where('name','=',$request['name'])->first();
            owner::create([
                'user_id' => $user_id['id'],
                'shops_id' => $shop_id['id'],
            ]);
        }else{
            shop::where('id','=',$request['id'])->first()->update([
                'name' => $request['name'],
                'area' => $request['area'],
                'genre' => $request['genre'],
                'overview' => $request['overview'],
            ]);
        }
        if(!empty($request['img'])){
            $img_name = $request['name'].".jpg";
            $request->file('img')->storeAs('public/images', $img_name);
        }
        $shop = owner::join('shops','owners.shops_id','shops.id')->where('user_id','=',$user_id['id'])->first();
        $reserve = reservation::join('shops','reservations.shops_id','shops.id')->where('shops_id','=',$shop['shops_id'])->get();
        $user = user::get();
        return view('shopowner', compact('shop','favorite','reserve','user'));
    }

    public function send_mail(Request $request){
        $to = user::where('name','=',$request['user_name'])->first();
        $to = $to['email'];
        $name = $request['user_name'];
        $shop = $request['reserve_name'];
        $date = $request['reserve_date'];
        $time = $request['reserve_time'];
        $number = $request['reserve_number'];
        Mail::to($to)->send(new SendMail($name,$shop,$date,$time,$number));
        $user_id = Auth::user();
        $favorite = 2;
        $shop = owner::join('shops','owners.shops_id','shops.id')->where('user_id','=',$user_id['id'])->first();
        $reserve = reservation::join('shops','reservations.shops_id','shops.id')->where('shops_id','=',$shop['shops_id'])->get();
        $user = user::get();
        return view('shopowner', compact('shop','favorite','reserve','user'));
    }

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

    public function check(Request $request){
        $favorite = 1;
        $user = user::join('reservations','users.id','reservations.user_id')->where('reservations.id','=',$request['id'])->first();
        $shop = shop::join('reservations','shops.id','reservations.shops_id')->where('reservations.id','=',$request['id'])->first();
        return view('check', compact('favorite','user','shop'));
    }
}

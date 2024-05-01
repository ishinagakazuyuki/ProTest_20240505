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
use App\Models\Reservation;
use App\Models\Owner;
use App\Http\Requests\CreateRequest;

class ManageController extends Controller
{
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

    public function check(Request $request){
        $favorite = 1;
        $user = user::join('reservations','users.id','reservations.user_id')->where('reservations.id','=',$request['id'])->first();
        $shop = shop::join('reservations','shops.id','reservations.shops_id')->where('reservations.id','=',$request['id'])->first();
        return view('check', compact('favorite','user','shop'));
    }
}

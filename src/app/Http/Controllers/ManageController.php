<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;

class ManageController extends Controller
{
    public function manage(Request $request){
        return view('manage');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $csvData = array_map('str_getcsv', explode("\n", $request->file('csv_file')->get()));
        foreach ($csvData as $index => $row) {
            $messages = [
                '0.required' => '店舗名は必須です。',
                '0.string' => '店舗名は文字列で入力してください。',
                '0.max' => '店舗名は50文字以内で入力してください。',
                '1.required' => '地域名は必須です。',
                '1.in' => '地域名は東京都、大阪府、福岡県のいずれかを指定してください。',
                '2.required' => 'ジャンル名は必須です。',
                '2.in' => 'ジャンル名は寿司、焼肉、イタリアン、居酒屋、ラーメンのいずれかを指定してください。',
                '3.required' => '店舗の説明は必須です。',
                '3.string' => '店舗の説明は文字列で入力してください。',
                '3.max' => '店舗の説明は400文字以内で入力してください。',
                '4.required' => '店舗のイメージ画像は必須です。',
            ];

            $validator = Validator::make($row, [
                '0' => 'required|string|max:50',
                '1' => 'required|in:東京都,大阪府,福岡県',
                '2' => 'required|in:寿司,焼肉,イタリアン,居酒屋,ラーメン',
                '3' => 'required|string|max:400',
                '4' => 'required',
            ], $messages);

            if ($validator->fails()) {
                Session::flash('error', $validator->errors()->toArray());
                return redirect()->back();
            } else {
                $tempPath = tempnam(sys_get_temp_dir(), 'img');
                file_put_contents($tempPath, file_get_contents($row[4]));
                $check = new UploadedFile(
                    $tempPath,
                    basename($tempPath),
                    mime_content_type($tempPath), 
                    null,
                    true
                );
                $validator = Validator::make(['image' => $check], [
                    'image' => 'image|mimes:jpg,jpeg,png',
                ]);
                if ($validator->fails()) {
                    Session::flash('error', $validator->errors()->toArray());
                    return redirect()->back();
                } else {
                    $path = Storage::putFile('public/images', $tempPath);
                    $filename = basename($path);
                    unlink($tempPath);
                    $areas_id = area::where('area','=',$row[1])->first();
                    $genres_id = genre::where('genre','=',$row[2])->first();
                    shop::create([
                        'name' => $row[0],
                        'areas_id' => $areas_id['id'],
                        'genres_id' => $genres_id['id'],
                        'overview' => $row[3],
                        'image' => $filename,
                    ]);
                }
            }
        }
    return redirect()->back()->with('success', 'CSVファイルのインポートが完了しました。');
    }
}

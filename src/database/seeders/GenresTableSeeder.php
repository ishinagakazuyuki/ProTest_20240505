<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Genre;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'genre' => '寿司',
        ];
        DB::table('genres')->insert($param);

        $param = [
            'genre' => '焼肉',
        ];
        DB::table('genres')->insert($param);

        $param = [
            'genre' => '居酒屋',
        ];
        DB::table('genres')->insert($param);

        $param = [
            'genre' => 'イタリアン',
        ];
        DB::table('genres')->insert($param);

        $param = [
            'genre' => 'ラーメン',
        ];
        DB::table('genres')->insert($param);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Area;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'area' => '東京都',
        ];
        DB::table('areas')->insert($param);

        $param = [
            'area' => '大阪府',
        ];
        DB::table('areas')->insert($param);

        $param = [
            'area' => '福岡県',
        ];
        DB::table('areas')->insert($param);
    }
}

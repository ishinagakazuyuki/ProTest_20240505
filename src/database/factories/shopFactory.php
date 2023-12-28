<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $customName = ['寿司昌', '焼肉ランド', 'よいどれ', '大盛家'];
        $selectedName = $this->faker->randomElements($customName, 1);

        $customArea = ['東京都', '大阪府', '福岡県'];
        $selectedArea = $this->faker->randomElements($customArea, 1);

        $customGenre = ['寿司', '焼肉', '居酒屋', 'ラーメン'];
        $selectedGenre = $this->faker->randomElements($customGenre, 1);

        return [
            'name' => implode(' ', $selectedName),
            'area' => implode(' ', $selectedArea),
            'genre' => implode(' ', $selectedGenre),
            'overview' => $this->faker->text(),
        ];
    }
}

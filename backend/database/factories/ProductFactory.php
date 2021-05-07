<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->catchPhrase();
        $quantity = 20;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text($maxNbChars = 100),
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 3),
            'total_quantity' => $quantity,
            'stock' => $quantity,
            'status' => $this->faker->randomElement([True, False])
        ];
    }
}

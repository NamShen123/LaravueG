<?php

namespace Database\Factories;

use App\Models\Books;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class BooksFactory extends Factory
{
    protected $model = Books::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(5),
            'description' => fake()->sentence(),
            'author' => fake()->name(),
            'price' => fake()->numberBetween(10, 500) * 1000,
            'quantity' => fake()->numberBetween(10,100),

        ];
    }


    public function setStatusId($statusId): Factory
    {
        return $this->state(function (array $attributes) use ($statusId) {
            return [
                'status_id' => $statusId,
            ];
        });
    }

    public function setQuantity($quantity): Factory
    {
        return $this->state(function (array $attributes) use ($quantity) {
            return [
                'quantity' => $quantity,
            ];
        });
    }

}

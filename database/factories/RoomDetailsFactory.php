<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\RoomDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomDetailsFactory extends Factory
{
    protected $model = RoomDetails::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "price" => rand(10000, 10000000),
            "capacity" => rand(2, 20),
            "description" => $this->faker->sentence(),
            "image" => "https://www.ahstatic.com/photos/5451_ho_00_p_1024x768.jpg",
            "hotel_id" => Hotel::inRandomOrder()->first()->id
        ];
    }
}

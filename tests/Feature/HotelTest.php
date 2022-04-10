<?php

namespace Tests\Feature;

use Database\Seeders\HotelSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HotelTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_hotel_is_valid()
    {
        $this->seed(HotelSeeder::class);
        
        $this->assertDatabaseHas("hotels", [
            'id' => 100,
            'name' => "OYO Hotel",
        ]);
    }
}

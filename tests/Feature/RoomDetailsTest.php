<?php

namespace Tests\Feature;

use Database\Seeders\RoomDetailSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoomDetailsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_hotel_is_valid()
    {
        $this->seed(RoomDetailSeeder::class);
        
        $this->assertDatabaseHas("room_details", [
            "hotel_id" => 100,
            "name"=> "Kings Gambit",
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_is_valid()
    {
        $this->seed(UserSeeder::class);
        
        $this->assertDatabaseHas("users", [
            "username" => "jontor",
            "role" => "user"
        ]);
    }
    
    public function test_user_login()
    {
        $response = $this->post('/api/login', ["username" => "jontor", "password" => "jontor"]);

        $response->assertStatus(200);
    }
}

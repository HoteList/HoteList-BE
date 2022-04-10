<?php

namespace Tests\Feature;

use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    public function test_admin_is_valid()
    {
        $this->seed(AdminSeeder::class);
        
        $this->assertDatabaseHas("users", [
            "username" => "admin",
            "role" => "admin"
        ]);
    }
    
    public function test_admin_login()
    {
        $this->seed(AdminSeeder::class);

        $response = $this->post('/api/login', ["username" => "admin", "password" => "admin123"]);

        $response->assertStatus(200);
    }
}

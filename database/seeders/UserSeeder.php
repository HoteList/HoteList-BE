<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create();

        DB::table('users')->insert([
            'id' => 69,
            'full_name' => 'jontor',
            'username' => 'jontor',
            'email' => 'jontor@mail.com',
            'password' => Hash::make('jontor'),
            'lat' => '1',
            'lot' => '1',
            'role' => 'user',
            'image' => 'https://awsimages.detik.net.id/community/media/visual/2019/09/25/fe853eb5-e5f8-453d-915e-63c71ce0cdc6.jpeg?w=750&q=90',
            'created_at' => '2002-12-12 00:00:00',
            'updated_at' => '2002-12-12 00:00:00'
        ]);
    }
}

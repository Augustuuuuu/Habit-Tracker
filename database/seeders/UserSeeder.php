<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'Augusto',
            'email' => 'augusto@gmail.com',
            'password' => '123456'
        ]);

        User::query()->create([
            'name' => 'Saboia',
            'email' => 'saboia@gmail.com',
            'password' => '123456'
        ]);
    }
}

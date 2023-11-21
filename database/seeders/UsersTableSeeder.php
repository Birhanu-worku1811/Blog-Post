<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersCount = (int) $this->command->ask('how many users do you want?', 20);
        User::factory()->state([
            'name' => 'Birhanu Worku',
            'email' => 'valid@valid.com',
            'is_admin' => true
        ])->create();
        User::factory($usersCount)->create();
    }
}

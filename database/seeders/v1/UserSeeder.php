<?php

namespace Database\Seeders\v1;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'phone' => '+998999999999',
            'password' => '1133557799',
            'role_id' => Role::SUPER_ADMIN,
        ]);

        User::create([
            'name' => 'Flutter Dev',
            'phone' => '+998991234567',
            'password' => '12345678',
            'role_id' => Role::USER,
        ]);

        User::factory()->count(15)->create();
    }
}

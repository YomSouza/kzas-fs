<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->createMany([
            [
                'name' => 'CTO',
                'email' => 'cto@email.com',
                'has_dashboard_access' => 1,
                'is_admin' => 1,
            ],
        ]);
    }
}

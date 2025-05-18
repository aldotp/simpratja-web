<?php

namespace Database\Seeders;

use App\Models\UserDetail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(MedicineSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserDetailSeeder::class);
    }
}
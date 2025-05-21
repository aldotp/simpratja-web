<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         {
        DB::table('user_details')->insert([
        [
            'name' => 'Admin Pertama',
            'gender' => 1,
            'phone_number' => '089251621525',
            'quota' => 0,
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Dokter Pertama',
            'gender' => 1,
            'phone_number' => '089251621525',
            'quota' => 20,
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Staff Pertama',
            'gender' => 1,
            'phone_number' => '089251621525',
            'quota' => 0,
            'user_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Leader Pertama',
            'gender' => 1,
            'phone_number' => '089251621525',
            'quota' => 0,
            'user_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        ]);
    }
    }
}

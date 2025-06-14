<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'password' => Hash::make('12345678a'),
            'role' => 'admin',
            'nik'=> '5412512512521601',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'password' => Hash::make('12345678a'),
            'role' => 'docter',
            'nik'=> '5412512512521602',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'password' => Hash::make('12345678a'),
            'role' => 'staff',
            'nik'=> '5412512512521603',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'password' => Hash::make('12345678a'),
            'role' => 'leader',
            'nik'=> '5412512512521604',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

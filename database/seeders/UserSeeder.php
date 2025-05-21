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
            'nik'=> '5125162162161',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'password' => Hash::make('12345678a'),
            'role' => 'docter',
            'nik'=> '5125162162162',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'password' => Hash::make('12345678a'),
            'role' => 'staff',
            'nik'=> '5125162162163',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'password' => Hash::make('12345678a'),
            'role' => 'leader',
            'nik'=> '5125162162164',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

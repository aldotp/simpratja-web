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
            'name' => 'User 1',
            'password' => Hash::make('12345678a'),
            'role' => 'patient',
            'nik'=> '5125162162161',
            'phone_number' => '089251621521',
            'gender' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Admin 1',
            'password' => Hash::make('12345678a'),
            'role' => 'admin',
            'nik'=> '5125162162162',
            'phone_number' => '089251621522',
            'gender' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Docter 1',
            'password' => Hash::make('12345678a'),
            'role' => 'docter',
            'nik'=> '5125162162163',
            'phone_number' => '089251621523',
            'gender' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Staff 1',
            'password' => Hash::make('12345678a'),
            'role' => 'staff',
            'nik'=> '5125162162164',
            'phone_number' => '089251621524',
            'gender' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Leader 1',
            'password' => Hash::make('12345678a'),
            'role' => 'leader',
            'nik'=> '5125162162165',
            'phone_number' => '089251621525',
            'gender' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
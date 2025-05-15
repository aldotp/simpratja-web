<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('docters')->insert([
            'name' => 'Docter Van Docter',
            'nik'=> '5125162162165',
            'gender' => 1,
            'phone_number' => '089251621525',
            'quota' => 20,
            'user_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
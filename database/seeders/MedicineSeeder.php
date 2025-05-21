<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            [
                'name' => 'Intunal',
                'unit' => 'Kaplet',
                'price' => 5000.00,
                'stock' => 100,
                'expiry_date' => '2027-12-12',
                'created_at' => '2025-05-11 15:22:05',
                'updated_at' => '2025-05-11 15:22:05'
            ],
            [
                'name' => 'Amodipin',
                'unit' => 'Kaplet',
                'price' => 5000.00,
                'stock' => 100,
                'expiry_date' => '2027-12-12',
                'created_at' => '2025-05-11 15:22:13',
                'updated_at' => '2025-05-11 15:22:13'
            ],
            [
                'name' => 'Sangobion',
                'unit' => 'Kapsul',
                'price' => 5000.00,
                'stock' => 50,
                'expiry_date' => '2027-12-12',
                'created_at' => '2025-05-12 00:27:43',
                'updated_at' => '2025-05-12 00:27:43'
            ],
            [
                'name' => 'Ibuprofen',
                'unit' => 'Kapsul',
                'price' => 7500.00,
                'stock' => 50,
                'expiry_date' => '2027-12-12',
                'created_at' => '2025-05-12 00:46:58',
                'updated_at' => '2025-05-12 00:46:58'
            ],
            [
                'name' => 'Paracetamol',
                'unit' => 'Tablet',
                'price' => 7500.00,
                'stock' => 100,
                'expiry_date' => '2027-12-12',
                'created_at' => '2025-05-12 00:47:42',
                'updated_at' => '2025-05-12 00:47:42'
            ]
        ];

        foreach ($medicines as $medicine) {
            Medicine::create($medicine);
        }
    }
}
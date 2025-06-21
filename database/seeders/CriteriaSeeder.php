<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Criteria;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criteriaData = [
            [
                'code' => 'C1',
                'name' => 'Kandungan Protein',
                'description' => 'Persentase kandungan protein dalam makanan kucing',
                'type' => 'benefit',
                'weight' => 35,
                'normalized_weight' => 0.35,
                'is_active' => true
            ],
            [
                'code' => 'C2',
                'name' => 'Lemak',
                'description' => 'Persentase kandungan lemak dalam makanan kucing',
                'type' => 'benefit',
                'weight' => 20,
                'normalized_weight' => 0.20,
                'is_active' => true
            ],
            [
                'code' => 'C3',
                'name' => 'Serat',
                'description' => 'Persentase kandungan serat dalam makanan kucing',
                'type' => 'benefit',
                'weight' => 10,
                'normalized_weight' => 0.10,
                'is_active' => true
            ],
            [
                'code' => 'C4',
                'name' => 'Kadar Air',
                'description' => 'Persentase kadar air dalam makanan kucing',
                'type' => 'benefit',
                'weight' => 10,
                'normalized_weight' => 0.10,
                'is_active' => true
            ],
            [
                'code' => 'C5',
                'name' => 'Harga',
                'description' => 'Harga makanan kucing dalam Rupiah',
                'type' => 'cost',
                'weight' => 25,
                'normalized_weight' => 0.25,
                'is_active' => true
            ]
        ];

        foreach ($criteriaData as $criteria) {
            Criteria::create($criteria);
        }
    }
}

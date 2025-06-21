<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alternative;

class AlternativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alternativesData = [
            [
                'code' => 'A1',
                'name' => 'Whiskas',
                'description' => 'Makanan kucing dry food untuk kitten',
                'protein' => 30.00,
                'fat' => 9.00,
                'fiber' => 5.00,
                'moisture' => 12.00,
                'price' => 40000,
                'brand' => 'Whiskas',
                'size' => '1.2 kg',
                'is_active' => true
            ],
            [
                'code' => 'A2',
                'name' => 'Royal Canin',
                'description' => 'Makanan kucing dry food untuk kitten premium',
                'protein' => 34.00,
                'fat' => 16.00,
                'fiber' => 4.00,
                'moisture' => 10.00,
                'price' => 75000,
                'brand' => 'Royal Canin',
                'size' => '1 kg',
                'is_active' => true
            ],
            [
                'code' => 'A3',
                'name' => 'Meo',
                'description' => 'Makanan kucing dry food untuk kitten',
                'protein' => 30.00,
                'fat' => 12.00,
                'fiber' => 5.00,
                'moisture' => 10.00,
                'price' => 65000,
                'brand' => 'Meo',
                'size' => '1.3 kg',
                'is_active' => true
            ],
            [
                'code' => 'A4',
                'name' => 'Grain Free',
                'description' => 'Makanan kucing dry food grain free untuk kitten',
                'protein' => 31.00,
                'fat' => 12.00,
                'fiber' => 5.00,
                'moisture' => 10.00,
                'price' => 130000,
                'brand' => 'Grain Free',
                'size' => '1 kg',
                'is_active' => true
            ],
            [
                'code' => 'A5',
                'name' => 'Cleo',
                'description' => 'Makanan kucing dry food untuk kitten',
                'protein' => 32.00,
                'fat' => 12.00,
                'fiber' => 5.00,
                'moisture' => 10.00,
                'price' => 70000,
                'brand' => 'Cleo',
                'size' => '1.5 kg',
                'is_active' => true
            ],
            [
                'code' => 'A6',
                'name' => 'Beauty',
                'description' => 'Makanan kucing dry food untuk kitten',
                'protein' => 30.00,
                'fat' => 12.00,
                'fiber' => 5.00,
                'moisture' => 10.00,
                'price' => 22000,
                'brand' => 'Beauty',
                'size' => '1 kg',
                'is_active' => true
            ],
            [
                'code' => 'A7',
                'name' => 'Markotop',
                'description' => 'Makanan kucing dry food untuk kitten',
                'protein' => 32.00,
                'fat' => 14.00,
                'fiber' => 4.00,
                'moisture' => 10.00,
                'price' => 22000,
                'brand' => 'Markotop',
                'size' => '1 kg',
                'is_active' => true
            ],
            [
                'code' => 'A8',
                'name' => 'Cat Choize',
                'description' => 'Makanan kucing dry food untuk kitten',
                'protein' => 30.00,
                'fat' => 9.00,
                'fiber' => 4.00,
                'moisture' => 10.00,
                'price' => 26000,
                'brand' => 'Cat Choize',
                'size' => '1 kg',
                'is_active' => true
            ],
            [
                'code' => 'A9',
                'name' => 'Lezatto',
                'description' => 'Makanan kucing dry food untuk kitten',
                'protein' => 28.00,
                'fat' => 8.00,
                'fiber' => 5.00,
                'moisture' => 10.00,
                'price' => 19000,
                'brand' => 'Lezatto',
                'size' => '1 kg',
                'is_active' => true
            ],
            [
                'code' => 'A10',
                'name' => 'Excel',
                'description' => 'Makanan kucing dry food untuk kitten',
                'protein' => 30.00,
                'fat' => 11.00,
                'fiber' => 3.00,
                'moisture' => 10.00,
                'price' => 14000,
                'brand' => 'Excel',
                'size' => '1 kg',
                'is_active' => true
            ]
        ];

        foreach ($alternativesData as $alternative) {
            Alternative::create($alternative);
        }
    }
}

<?php

namespace Database\Seeders\v1;

use App\Models\Tariff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TariffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tariff::create([
            'title' => [
                'ltn' => "Premium",
                'cyr' => "Премиум",
            ],
            'description' => [
                'ltn' => 'Premium akkaunt!',
                'cyr' => 'Премиум аккаунт!'
            ],
            'month' => 2,
            'price' => 150000
        ]);
    }
}

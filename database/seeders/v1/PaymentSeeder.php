<?php

namespace Database\Seeders\v1;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::create(['title' => 'Click']);
        Payment::create(['title' => 'Payme']);
        Payment::create(['title' => 'Uzum bank']);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Classification;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classification::factory()
        ->count(2)
        ->hasMedicines(5)
        ->create();

        Classification::factory()
        ->count(3)
        ->hasMedicines(3)
        ->create();

        Classification::factory()
        ->count(1)
        ->hasMedicines(10)
        ->create();
    }
}

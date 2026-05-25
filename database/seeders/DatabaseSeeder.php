<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Crop::seedDefaults();
        User::seedDefaults();
        Product::seedDefaults();
    }
}

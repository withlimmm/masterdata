<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        Package::create([
            'package_code' => 'PKG-BASIC',
            'package_name' => 'Basic Plan',
            'package_max_products' => 50,
            'package_price' => 99000,
        ]);

        Package::create([
            'package_code' => 'PKG-PRO',
            'package_name' => 'Professional Plan',
            'package_max_products' => 500,
            'package_price' => 299000,
        ]);

        Package::create([
            'package_code' => 'PKG-ENT',
            'package_name' => 'Enterprise Plan',
            'package_max_products' => 999999,
            'package_price' => 999000,
        ]);
    }
}

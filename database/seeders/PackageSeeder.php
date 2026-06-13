<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\System;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $posSystem = System::where('system_code', 'SYS-POS')->first();

        Package::create([
            'system_id' => $posSystem->id ?? null,
            'package_code' => 'PKG-BASIC',
            'package_name' => 'Basic Plan',
            'package_benefits' => "100 Transaksi per Bulan\nLaporan Standar\nDukungan Email",
            'package_price' => 99000,
        ]);

        Package::create([
            'system_id' => $posSystem->id ?? null,
            'package_code' => 'PKG-PRO',
            'package_name' => 'Professional Plan',
            'package_benefits' => "Transaksi Tidak Terbatas\nLaporan Lanjutan\nDukungan Prioritas\nManajemen Inventori",
            'package_price' => 299000,
        ]);

        Package::create([
            'system_id' => $posSystem->id ?? null,
            'package_code' => 'PKG-ENT',
            'package_name' => 'Enterprise Plan',
            'package_benefits' => "Semua Fitur Pro\nAkses API\nCustom Domain\nManajer Akun Dedikasi",
            'package_price' => 999000,
        ]);
    }
}

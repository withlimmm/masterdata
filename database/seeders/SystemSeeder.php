<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        System::create([
            'system_code' => 'SYS-POS',
            'system_name' => 'Point of Sales (POS) System',
            'description' => 'Sistem Kasir dan Manajemen Penjualan untuk Toko / F&B',
        ]);

        System::create([
            'system_code' => 'SYS-WMS',
            'system_name' => 'Warehouse Management System',
            'description' => 'Sistem Manajemen Gudang dan Inventaris',
        ]);
    }
}

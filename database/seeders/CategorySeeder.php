<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat data kategori mobil default.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'City Car', 'description' => 'Mobil mungil hemat BBM, cocok untuk berkendara di dalam kota.'],
            ['name' => 'MPV', 'description' => 'Mobil keluarga dengan kabin luas dan kapasitas penumpang besar.'],
            ['name' => 'SUV', 'description' => 'Mobil tangguh dengan ground clearance tinggi, cocok untuk berbagai medan.'],
            ['name' => 'Sedan', 'description' => 'Mobil elegan dengan kenyamanan berkendara premium.'],
            ['name' => 'Premium / Luxury', 'description' => 'Mobil mewah kelas eksekutif dengan kenyamanan, performa, dan kemewahan terbaik.'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], ['description' => $category['description']]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DapertemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dapertemen = [
            [
                'kode' => 'HRD',
                'nama_dapertemen' => 'Human Resource Development',
                'slug' => 'human-resource-development'
            ],
            [
                'kode' => 'IT',
                'nama_dapertemen' => 'Information Technology',
                'slug' => 'information-technology'
            ],
            [
                'kode' => 'FIN',
                'nama_dapertemen' => 'Finance',
                'slug' => 'finance'
            ],
        ];

        foreach ($dapertemen as $data) {
            \App\Models\Dapertemen::create([
                'kode' => $data['kode'],
                'nama_dapertemen' => $data['nama_dapertemen'],
                'slug' => $data['slug']
            ]);
        }
    }
}

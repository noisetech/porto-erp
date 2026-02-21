<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatan = [
            [
                'dapertemen_id' => 1,
                'jabatan' => 'Manager HRD',
                'slug' => 'manager-hrd'
            ],
            [
                'dapertemen_id' => 1,
                'jabatan' => 'Staff HRD',
                'slug' => 'staff-hrd'
            ],
            [
                'dapertemen_id' => 2,
                'jabatan' => 'Manager IT',
                'slug' => 'manager-it'
            ],
            [
                'dapertemen_id' => 2,
                'jabatan' => 'Staff IT',
                'slug' => 'staff-it'
            ],
            [
                'dapertemen_id' => 3,
                'jabatan' => 'Manager Finance',
                'slug' => 'manager-finance'
            ],
            [
                'dapertemen_id' => 3,
                'jabatan' => 'Staff Finance',
                'slug' => 'staff-finance'
            ],
        ];

        foreach ($jabatan as $data) {
            \App\Models\Jabatan::create([
                'dapertemen_id' => $data['dapertemen_id'],
                'jabatan' => $data['jabatan'],
                'slug' => $data['slug']
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Tips Sehat',
                'slug' => 'tips-sehat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Info Kesehatan',
                'slug' => 'info-kesehatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Event',
                'slug' => 'event',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

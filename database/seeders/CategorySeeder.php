<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Classification;
use App\Utils\CSVReader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(int $classification_id): void
    {
        $categories = new CSVReader(database_path('seeders/data/categories.csv'), ['str', 'str', 'str', 'str'])
            ->read()
            ->getData();
        $categories = array_map(fn(array $c) => [...$c, 'classification_id' => $classification_id], $categories);
        DB::transaction(function() use($categories) {
            Category::insert($categories);
        });
    }
}

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
        $c = new Classification();
        $c->title = 'دسته بندی تور';
        $c->save();
        $this->call(CategorySeeder::class, parameters: ['classification_id' => $c->id]);
    }
}

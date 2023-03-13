<?php

namespace Database\Seeders;

use App\models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = config('types');

        foreach ($types as $type) {
            $new_type = new Type();

            $new_type->label = $type['label'];
            $new_type->color = $type['color'];

            // $new_type->fill($type);
            $new_type->save();
        }
    }
}

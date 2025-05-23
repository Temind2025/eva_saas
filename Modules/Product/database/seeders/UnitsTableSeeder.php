<?php

namespace Modules\Product\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Product\Models\Unit;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'gm',
                'created_by' => 2,
                'updated_by' => 2,
            ],
            [
                'name' => 'kg',
                'created_by' => 2,
                'updated_by' => 2,
            ],
            [
                'name' => 'pcs',
                'created_by' => 2,
                'updated_by' => 2,
            ],
            [
                'name' => 'ml',
            ],
            [
                'name' => 'pack',
            ],
            [
                'name' => 'ltr',
            ],
            [
                'name' => 'each',
            ],
            [
                'name' => '250gm',
            ],
        ];

        if (env('IS_DUMMY_DATA')) {
            foreach ($data as $key => $value) {
                Unit::create($value);
            }
        }
    }
}

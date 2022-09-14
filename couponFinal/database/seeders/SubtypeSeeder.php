<?php

namespace Database\Seeders;
use App\Models\Subtype;


use Illuminate\Database\Seeder;

class SubtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subtypes = [
            [
                'subtype_name' => '%off'
            ],
            [
                'subtype_name' => 'flat'
            ],
            [
                'subtype_name' => 'free'
            ]
        ];

        foreach ($subtypes as $key => $value) {
            Subtype::create($value);
        }
    }
    }


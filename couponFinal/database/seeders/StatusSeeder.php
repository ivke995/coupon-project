<?php

namespace Database\Seeders;
use App\Models\Status;


use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'status_name' => 'active'
            ],
            [
                'status_name' => 'used'
            ],
            [
                'status_name' => 'inactive'
            ]
        ];

        foreach($statuses as $key => $value) {
            Status::create($value);
        }
    }
}

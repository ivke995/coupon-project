<?php

namespace Database\Seeders;
use App\Models\Admin;


use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'name' => 'marko',
                'email' => 'marko@gmail.com',
                'password' => '$2y$10$e5gDrcanfioL3nSuj/4q6uEJoPYQe8aDcGRiS1GdbrhUqq2.0tpNu'
            ]
        ];

        foreach($admins as $key => $value) {
            Admin::create($value);
        }
    }
}

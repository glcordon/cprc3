<?php

use App\CrmStatus;
use Illuminate\Database\Seeder;

class CrmStatusTableSeeder extends Seeder
{
    public function run()
    {
        $crmStatuses = [
            [
                'id'         => '1',
                'name'       => 'Lead',
                'created_at' => '2020-06-30 03:35:47',
                'updated_at' => '2020-06-30 03:35:47',
            ],
            [
                'id'         => '2',
                'name'       => 'Customer',
                'created_at' => '2020-06-30 03:35:47',
                'updated_at' => '2020-06-30 03:35:47',
            ],
            [
                'id'         => '3',
                'name'       => 'Partner',
                'created_at' => '2020-06-30 03:35:47',
                'updated_at' => '2020-06-30 03:35:47',
            ],
        ];

        CrmStatus::insert($crmStatuses);
    }
}

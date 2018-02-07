<?php

use Illuminate\Database\Seeder;

class BailConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $bailConfiguration = [
                                [
                                    'bc_create_at' => date('Y-m-d G:i:s'),
                                    'bc_active' => 1,
                                    'bc_category' => 'bail_fee',
                                    'bc_type' => 'regular',
                                    'bc_value' => '3',
                                ],
                                [
                                    'bc_create_at' => date('Y-m-d G:i:s'),
                                    'bc_active' => 1,
                                    'bc_category' => 'transaction_type',
                                    'bc_type' => 'R',
                                    'bc_value' => 'Bail Receipt',
                                ],
                                [
                                    'bc_create_at' => date('Y-m-d G:i:s'),
                                    'bc_active' => 1,
                                    'bc_category' => 'transaction_type',
                                    'bc_type' => 'C',
                                    'bc_value' => 'County Fee',
                                ],

        ];

        DB::table('bail_configuration')->insert($bailConfiguration);
    }
}

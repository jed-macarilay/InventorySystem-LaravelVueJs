<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            [
                'role' => 'Cashier',
            ],
        );

        DB::table('roles')->insert(
            [
                'role' => 'Driver',
            ],
        );
    }
}

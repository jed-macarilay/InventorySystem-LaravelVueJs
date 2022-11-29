<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name' => 'Admin',
                'email' => 'admin@denlee',
                'user_type' => 'admin',
                'password' => Hash::make('denlee@pass'),
            ],
        );

        DB::table('users')->insert(
            [
                'name' => 'Edrian Agenga',
                'email' => 'dev1@denlee',
                'user_type' => 'admin',
                'password' => Hash::make('denlee@pass'),
            ],
        );

        DB::table('users')->insert(
            [
                'name' => 'Nico Candaroma',
                'email' => 'dev2@denlee',
                'user_type' => 'admin',
                'password' => Hash::make('denlee@pass'),
            ],
        );

        DB::table('users')->insert(
            [
                'name' => 'Vargas Kenneth',
                'email' => 'dev3@denlee',
                'user_type' => 'admin',
                'password' => Hash::make('denlee@pass'),
            ],
        );

        DB::table('users')->insert(
            [
                'name' => 'Kim Caparas',
                'email' => 'dev4@denlee',
                'user_type' => 'admin',
                'password' => Hash::make('denlee@pass'),
            ],
        );
    }
}

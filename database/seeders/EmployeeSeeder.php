<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->delete();
        $empRecord = [
            [
                'name' => 'Abdul Jabber',
                'email' => 'asallam@email.com',
                'phone' => '01531 XXXXXX',
                'password' => Hash::make('12345678')
            ]
        ];
        DB::table('employees')->insert($empRecord);
    }
}

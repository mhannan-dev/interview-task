<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminsRecord = [
            [
                'name' => 'M Hannan',
                'type' => 'admin',
                'email_phone' => 'admin@admin.com',
                'password' => Hash::make('12345678')
            ],
            [
                'name' => 'Employee One',
                'type' => 'employee',
                'email_mobile' => 'employee@email.com',
                'password' => Hash::make('12345678')
            ]

        ];
        DB::table('admins')->insert($adminsRecord);
    }
}

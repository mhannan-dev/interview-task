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
                'type' => 'ADMIN',
                'email' => 'admin@admin.com',
                'phone' => '01521141412',
                'password' => Hash::make('12345678')
            ],
            [
                'name' => 'Employee One',
                'type' => 'EMP',
                'mobile' => 'employee@email.com',
                'phone' => '01231112211',
                'password' => Hash::make('12345678')
            ]

        ];
        DB::table('admins')->insert($adminsRecord);
    }
}

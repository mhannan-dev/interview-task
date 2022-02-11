<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->delete();
        $adminsRecord = [
            [
                'name' => 'Abdus Salam',
                'email' => 'asallam@email.com',
                'phone' => '01231151218',
                'password' => Hash::make('12345678')
            ],
            [
                'name' => 'Sumit Saha',
                'email' => 'sumit@email.com',
                'phone' => '01131131619',
                'password' => Hash::make('12345678')
            ]
        ];
        DB::table('customers')->insert($adminsRecord);
    }
}

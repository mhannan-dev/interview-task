<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomerImport implements ToModel
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::all();
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Customer([
            'name'     => $row[0],
            'email'    => $row[1],
            'phone'    => $row[2],
            'password' => Hash::make($row[3]),
            'admin_id'    =>  Auth::guard('admin')->user()->id
        ]);
    }
}

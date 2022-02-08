<?php

namespace App\Http\Controllers\Admin;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Admin;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function employees()
    {
        Session::put('page', 'employees');
        $data['title'] = "All Employees";
        $data['employees'] = Admin::where('type', '=', 'EMP')->get();
        //dd($data['employees']);
        return view('admin.pages.emp.employees',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addEditEmployee(Request $request, $id = null)
	{
        if ($id == "") {
			$employee = new Admin();
			$title = "Add new employee";
			$message = "Employee has been saved successfully!";
			$buttonText = "Save";
		} else {
			$employee = Admin::findOrFail($id)->where('type', '=', 'EMP');
			$title = "Edit Employee";
			$buttonText = "Update";
			//dd($address);
			$message = "Employee has been updated successfully!";
		}
		//exit;
		try {
			if ($request->isMethod('POST')) {
				$data = $request->all();
				//echo '<pre>';print_r($data);die;
				//Form validation
				$rules = [
					'name' => 'required|regex:/^[\pL\s\-]+$/u',
					'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits:11',
					'password' => 'required',
				];
				$validationMessages = [
					'name.regex' => 'The name field can not be blank',
					'phone.digits' => 'The mobile no field must be 11 digits',
					'phone.numeric' => 'The mobile no must be numeric',
					'phone.required' => 'The mobile no is required',
					'password.required' => 'The password is required'

				];
				$this->validate($request, $rules, $validationMessages);
				$employee->name = $data['name'];
				$employee->type = "EMP";
				$employee->phone = $data['phone'];
				$employee->email = $data['email'];
				$employee->password = Hash::make($data['password']);
				$employee->save();
				return redirect()->route('employees')->with('success', $message);
			}
		} catch (\Throwable $th) {
			throw $th;
		}
		return view('admin.pages.emp.addEditEmp', compact('title','employee','buttonText'));
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployeeRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}

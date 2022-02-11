<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customers()
    {
        Session::put('page', 'customers');
        $data['title'] = "Customer";
        $data['customers'] = Customer::orderBy('id', 'desc')->get();
        //dd($data['customers']);
        return view('admin.pages.customer.customers', $data);
    }
    /**
     * Add Edit Customer Method
     *
     * @return \Illuminate\Http\Response
     */
    public function addEditCustomer(Request $request, $id = null)
    {
        if ($id == "") {
            $customer = new Customer();
            $title = "Add Customer";
            $message = "Customer has been saved successfully!";
            $buttonText = "Save";
        } else {
            $customer = Customer::findOrFail($id);
            $title = "Edit customer";
            $buttonText = "Update";
            //dd($address);
            $message = "Customer has been updated successfully!";
        }
        //exit;
        try {
            if ($request->isMethod('POST')) {
                $data = $request->all();
                //echo '<pre>';print_r($data);die;
                //Form validation
                $rules = [
                    'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits:11',
                    'email' => 'required|email|unique:customers',
                    'password' => 'required|min:6',
                ];
                $validationMessages = [
                    'name.regex' => 'The name field can not be blank',
                    'phone.digits' => 'The mobile no field must be 11 digits',
                    'phone.numeric' => 'The mobile no must be numeric',
                    'phone.required' => 'The mobile no is required',
                    'email.required' => 'The email is required',
                    'password.required' => 'The password is required'
                ];
                $this->validate($request, $rules, $validationMessages);
                $customer->name = $data['name'];
                $customer->admin_id = Auth::guard('admin')->user()->id;
                $customer->phone = $data['phone'];
                $customer->email = $data['email'];
                $customer->password = Hash::make($data['password']);
                $customer->save();
                return redirect()->back()->with('success', $message);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('customers')->with('error', 'Failed');
        }
        return view('admin.pages.customer.addEditCustomer', compact('title', 'customer', 'buttonText'));
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function uploadContent(Request $request)
    {
        //dd($request->file('file'));
        $file = $request->file('file');
        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes
            //Check for file extension and size
            $this->checkUploadedFileProperties($extension, $fileSize);
            //Where uploaded file will be stored on the server
            $location = 'uploads'; //Created an "uploads" folder for that
            // Upload file
            $file->move($location, $filename);
            // In case the uploaded file path is to be stored in the database
            $filepath = public_path($location . "/" . $filename);
            // Reading file
            $file = fopen($filepath, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;
            //dd($importData_arr);
            //Read the contents of the uploaded file
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                //dd($filedata);
                // Skip first row (Remove below comment if you want to skip the first row)
                if ($i == 0) {
                    $i++;
                    continue;
                }
                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }
            fclose($file); //Close after reading
            $j = 0;
            foreach ($importData_arr as $importData) {
                // $name = $importData[1]; //Get user names
                // $email = $importData[3]; //Get the user emails
                $j++;
                try {
                    DB::beginTransaction();
                    Customer::create([
                        'name' => $importData[1],
                        'phone' => $importData[2],
                        'email' => $importData[3],
                        'password' => Hash::make($importData[4]),
                        'admin_id'    =>  Auth::guard('admin')->user()->id
                    ]);
                    DB::commit();
                } catch (\Exception $e) {
                    throw $e;
                    DB::rollBack();
                }
            }
            return back()->with('success', 'Records successfully uploaded');
        } else {
            //no file was uploaded
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }
    //Check Uploaded File Properties
    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = array("csv"); //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }

    public function liveSearch(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('search');
            if ($query != '') {
                $customers = Customer::where('name', 'Like', '%' . $query . '%')->get();
                foreach ($customers as $customer) {
                    $output .= '<tr><td>' . $customer->name . '</td><td>' . $customer->phone . '</td><td>' . $customer->email . '</td><td>' . date('Y-m-d', strtotime($customer->created_at)) . '</td><td>' . '</td></tr>';
                }
                return response($output);
            }
        } else {
            echo 'else logic';
        }
    }
    //Check customer email
    public function checkEmail(Request $request)
    {
        $data = $request->all();
        $emailCount = Customer::where('email', $data['email'])->count();
        //dd($emailCount);
        if ($emailCount > 0) {
            return "false";
        } else {
            return "true";
        }
    }
    //Check customer email
    public function checkPhone(Request $request)
    {
        $data = $request->all();
        $phoneCount = Customer::where('phone', $data['phone'])->count();
        //dd($emailCount);
        if ($phoneCount > 0) {
            return "false";
        } else {
            return "true";
        }
    }
}

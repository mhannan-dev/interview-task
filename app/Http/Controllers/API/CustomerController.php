<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Customer;

class CustomerController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request, $id)
    {

        $customer = Customer::find($id);
        if ($customer->token !== $request->token) {
            return 'false';
        }
    }
    public function logoutApi()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}

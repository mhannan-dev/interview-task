<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function apiLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = Customer::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('LaravelPassportClient')->accessToken;
                $customerName = $user->name;
                DB::table('customers')->where('email', $request->email)->update(['auth_token' => $token]);
                return response()->json(
                    ['message' => 'You are logged in', 'token' => $token,'name'=> $customerName],
                    200
                );
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
    }
    //Logged in customer Details
    public function customerDetails($id)
    {
        $customer = Customer::find($id);
        if ($customer->auth_token) {
            return response()->json(
                ['message' => 'Welcome............', 'name'=> $customer->name],
                200
            );
        } else {
            $response = ["message" => 'Customer not logged in'];
            return response($response, 422);
        }

    }
    public function logout($id)
    {
        $customer = Customer::find($id);
        if ($customer->auth_token) {
            DB::table('customers')->where('id', $id)->update(['auth_token' => null]);
            return response()->json([
                'success' => true,
                'message' => 'Customer logged out successfully',
            ], 200);
        }
        else{
            return response()->json([
                'success' => true,
                'message' => 'Unauthorised',
            ], 422);
        }
    }
}

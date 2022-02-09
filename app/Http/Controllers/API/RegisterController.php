<?php
namespace App\Http\Controllers\API;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;

class RegisterController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = Customer::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                //$token = $user->createToken('loginToken')->accessToken;
                $token = $user->createToken(Str::random(32))->accessToken;
                //$user->update(["token" => $token]);
               DB::table('customers')->where('email', $request->email)->update(['token' => $token->name]);
                return response()-> json(
                    [
                        'message' => 'You are logged in',
                        'token' => $token
                    ],200);
            } else {
                return response()->json(
                    ['error' => 'Email or password is invalid'], 422);
            }
        } else {
            return response()->json(['error' => 'Customer does not exist'], 401);
        }
    }
}

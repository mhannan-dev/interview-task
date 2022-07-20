<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\Models\User;
use App\Mail\NotifyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\TokenRepository;
use Illuminate\Support\Facades\Validator;

class PassportController extends Controller
{
    /**
     * Register user.
     *
     * @return json
     */
    public function register(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:4',
            'last_name' => 'required|string|min:4',
            'email' => 'required|email',
            'username' => 'required|string|min:10',
            'password' => 'required|confirmed|min:8',
        ]);
        //Check validation failure
        if ($validator->fails()) {
            return response()->json([
                'success' => true,
                'errors' => $validator->errors(),
            ], 401);
        }
        //Saving other field to posts table
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();
        $otp = rand(1000, 9999);
        if ($user) {
            $mail_details = [
                'name' => $user->first_name .' '. $user->last_name,
                'otp' => 'Your OTP is : ' . $otp
            ];
            Mail::to($request['email'])->send(new NotifyMail($mail_details));
            return response(["status" => 200, "message" => "User registered successfully, OTP sent successfully"]);
        } else {
            return response(["status" => 401, 'message' => 'Invalid']);
        }
    }

    /**
     * Login user.
     *
     * @return json
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        }
        //Get authenticated admin
        $admin = User::where('email', $request->email)->first();
        //Check Above Admin
        if ($admin) {
            if (Hash::check($request->password, $admin->password)) {
                $token = $admin->createToken('LaravelPassportClient')->accessToken;
                return response()->json(
                    ['message' => 'You are logged in', 'token' => $token],
                    200
                );
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'Wrong credentials! please input correct email and password'];
            return response($response, 422);
        }
    }

    /**
     * Access method to authenticate.
     *
     * @return json
     */
    public function users()
    {
        $limit = $request['limit'] ?? 10;
        $offset = $request['offset'] ?? 1;
        $result = User::latest()->paginate($limit, ['*'], 'page', $offset);
        $data = [
            'total' => $result->total(),
            'limit' => $limit,
            'offset' => $offset,
            'users' => $result->items(),
        ];
        return response()->json($data, 200);
    }
    public function updateProfile(Request $request)
    {
        $user = User::findOrFail($request->id);
        $data = $request->only(['first_name', 'last_name','phone','image','password']);

        $validate_data = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
        ];

        $validator = Validator::make($data, $validate_data);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ]);
        }
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->phone = $data['phone'];
        $user->image = $data['image'] ? Helpers::update('user/', $user->image, 'png', $data['image']) : $user->image;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);


    }


    /**
     * Logout user.
     *
     * @return json
     */
    public function logout()
    {
        $access_token = auth()->user()->token();
        $tokenRepository = app(TokenRepository::class);
        $tokenRepository->revokeAccessToken($access_token->id);
        return response()->json([
            'success' => true,
            'message' => 'User logout successfully.'
        ], 200);
    }
}

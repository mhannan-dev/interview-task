<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        Session::put('page', 'dashboard');
        $data['title'] = "Dashboard";
        return view('admin.pages.settings.dashboard', $data);
    }

    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            return [
                'phone' => $request->get('email'),
                'password' => $request->get('password')
            ];
        } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return [
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ];
        }
    }
    // protected function credentials(Request $request)
    // {
    //     if (is_numeric($request->get('email'))) {
    //         return [
    //             'phone' => $request->get('email'),
    //             'password' => $request->get('password')
    //         ];
    //     } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
    //         return [
    //             'email' => $request->get('email'),
    //             'password' => $request->get('password')
    //         ];
    //     }
    //     return ['username' => $request->get('email'), 'password' => $request->get('password')];
    // }

    /**
     * Admin Form
     *
     */
    public function showLoginForm()
    {
        return view('admin.pages.settings.admin_login');
    }
    /**
     * Admin login
     *
     */
    public function login(Request $request)
    {
        // if ($request->isMethod('POST')) {
        //     $data = $request->all();
        //     //Validation rules
        //     $rules = [
        //         'email_phone' => 'required',
        //         'password' => 'required',
        //     ];
        //     //Validation message
        //     $customMessage = [
        //         'email_phone.required' => 'Email or phone is required',
        //         'password.required' => 'Password is required',
        //     ];
        //     $this->validate($request, $rules, $customMessage);
        //     if (Auth::guard('admin')->attempt(
        //         [
        //             'email_phone' => $data['email_phone'], 'password' => $data['password']
        //         ]
        //     )) {
        //         return redirect('admin/dashboard')->with('success', 'Login Successfully!');
        //     } else {
        //         return back()->with('error', 'Username or password is wrong');
        //     }
        // }
        // return view('admin.pages.settings.admin_login');
        if ($request->isMethod('POST')) {
            $data = $request->all();
            //Validation rules
            $rules = [
                'phone' => 'required',
                'password' => 'required',
            ];
            //Validation message
            $customMessage = [
                'phone.required' => 'Email or phone is required',
                'password.required' => 'Password is required',
            ];
            $this->validate($request, $rules, $customMessage);
            $fieldType = filter_var($request->phone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
            if (Auth::guard('admin')->attempt(
                array($fieldType => $data['phone'], 'password' => $data['password'])
            )) {
                return redirect('admin/dashboard')->with('success', 'Login Successfully!');
            } else {
                return back()->with('error', 'Username or password is wrong');
            }
        }
        return view('admin.pages.settings.admin_login');
    }
    /**
     * Admin logout
     *
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        //return view('admin.pages.settings.admin_login');
        return redirect('/');
    }
}

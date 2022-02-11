<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin as ModelsAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     */
    public function dashboard()
    {
        Session::put('page', 'dashboard');
        $data['title'] = "Dashboard";
        $data['employee'] = DB::table('admins')->where('type', '=', 'EMP')->count();
        $data['customer'] = DB::table('customers')->count();
        $data['admin'] = DB::table('admins')->where('type', '=', 'ADMIN')->count();
        //dd($data['employee']);
        return view('admin.pages.settings.dashboard', $data);
    }
    /**
     * Phone and email related credentials
     *
     */
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
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('admin.pages.settings.admin_login');
    }
    /**
     * Do Admin login
     *
     */
    public function login(Request $request)
    {
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
     * Complete Admin logout
     *
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}

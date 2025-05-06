<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = '/categories';
    protected function redirectTo()
    {
        // Kiểm tra role của admin sau khi đăng nhập
        if (Auth::guard('admin')->user()->role === 'super_admin') {
            return '/categories';  // Redirect đến dashboard của super admin
        } elseif (Auth::guard('admin')->user()->role === 'admin') {
            return '/brands';  // Redirect đến trang categories cho admin
        } elseif (Auth::guard('admin')->user()->role === 'support_staff') {
            return '/orders';  // Redirect đến trang orders cho support staff
        }
        return '/home';  // Default redirect nếu không có role phù hợp
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth:admin')->only('logout');
    }

    /**
     * Override the default guard to use the admin guard.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');  // Sử dụng guard admin thay vì mặc định 'web'
    }
}

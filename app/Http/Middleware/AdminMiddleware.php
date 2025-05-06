<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Lấy người dùng đã đăng nhập
        $user = Auth::guard('admin')->user();

        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!$user) {
            return redirect()->route('login');  // Chuyển hướng đến trang login nếu chưa đăng nhập
        }

        // Kiểm tra vai trò của người dùng
        if ($role === 'super_admin' && $user->role !== 'super_admin') {
            return redirect()->route('home');  // Chuyển hướng nếu không phải super admin
        }

        if ($role === 'admin' && $user->role !== 'admin' && $user->role !== 'super_admin') {
            return redirect()->route('home');  // Chuyển hướng nếu không phải admin hoặc super admin
        }

        if ($role === 'support_staff' && $user->role !== 'support_staff' && $user->role !== 'super_admin') {
            return redirect()->route('home');  // Chuyển hướng nếu không phải support staff hoặc super admin
        }

        // Nếu vai trò hợp lệ, tiếp tục với yêu cầu
        return $next($request);
    }
}

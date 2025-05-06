<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
{
    public function handle(Request $request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin && $admin->status != 1) {
            Auth::guard('admin')->logout();

            return redirect()->route('login')->withErrors([
                'email' => 'Account has been disabled.',
            ]);
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('admin.change-password');
    }

    public function processChangePassword(Request $request)
    {
        // Xác thực các dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        // Lấy thông tin người dùng admin hiện tại
        $admin = Admin::where('id', Auth::guard('admin')->user()->id)->first();

        // Kiểm tra nếu các dữ liệu đầu vào hợp lệ
        if ($validator->passes()) {
            // Kiểm tra mật khẩu cũ
            if (!Hash::check($request->old_password, $admin->password)) {
                session()->flash('error', 'Old password is incorrect');
                return response()->json([
                    'status' => false,
                ]);
            }

            // Cập nhật mật khẩu mới
            Admin::where('id', Auth::guard('admin')->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            session()->flash('success', 'Password changed successfully');
            return response()->json([
                'status' => true,
            ]);
        } else {
            // Nếu validation không hợp lệ
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}

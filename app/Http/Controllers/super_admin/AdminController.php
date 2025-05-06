<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $admins = Admin::where('role', 'admin')->latest();

        if ($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $admins = $admins->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%");
            });
        }

        $admins = $admins->paginate(10);

        return view('super_admin.admin.list', compact('admins'));
    }
    public function create()
    {
        return view('super_admin.admin.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
            ]);
        }

        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->password = Hash::make($request->password);
        $admin->role = 'admin';
        $admin->status = $request->status ?? 1;
        $admin->save();

        session()->flash('success', 'Admin created successfully');
        return response()->json([
            'status' => true,
            'message' => 'Admin created successfully',
        ]);
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            session()->flash('error', 'Admin not found');
            return redirect()->route('admins.index');
        }

        return view('super_admin.admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json([
                'status' => false,
                'message' => 'Admin not found',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,'.$id,
            'phone' => 'required|string|max:15'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
            ]);
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->role = 'admin';
        $admin->status = $request->status;
        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        session()->flash('success', 'Admin updated successfully');
        return response()->json([
            'status' => true,
            'message' => 'Admin updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json([
                'status' => false,
                'message' => 'Admin not found',
            ]);
        }

        $admin->delete();

        session()->flash('success', 'Admin deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Admin deleted successfully',
        ]);
    }
}

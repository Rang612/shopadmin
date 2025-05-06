<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $staffs = Admin::where('role', 'support_staff')->latest();

        if ($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $staffs = $staffs->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%");
            });
        }

        $staffs = $staffs->paginate(10);

        return view('admin.support_staff.list', compact('staffs'));
    }

    public function create()
    {
        return view('admin.support_staff.create');
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

        $staff = new Admin();
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->phone = $request->phone;
        $staff->password = Hash::make($request->password);
        $staff->role = 'support_staff';
        $staff->status = $request->status ?? 1;
        $staff->save();

        session()->flash('success', 'Support staff created successfully');
        return response()->json([
            'status' => true,
            'message' => 'Support staff created successfully',
        ]);
    }

    public function edit($id)
    {
        $staff = Admin::find($id);
        if (!$staff || $staff->role !== 'support_staff') {
            session()->flash('error', 'Support staff not found');
            return redirect()->route('support_staff.index');
        }

        return view('admin.support_staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = Admin::find($id);
        if (!$staff || $staff->role !== 'support_staff') {
            return response()->json([
                'status' => false,
                'message' => 'Support staff not found',
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

        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->phone = $request->phone;
        $staff->role = 'support_staff';
        $staff->status = $request->status;
        if ($request->password) {
            $staff->password = Hash::make($request->password);
        }
        $staff->save();

        session()->flash('success', 'Support staff updated successfully');
        return response()->json([
            'status' => true,
            'message' => 'Support staff updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $staff = Admin::find($id);
        if (!$staff || $staff->role !== 'support_staff') {
            return response()->json([
                'status' => false,
                'message' => 'Support staff not found',
            ]);
        }

        $staff->delete();

        session()->flash('success', 'Support staff deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Support staff deleted successfully',
        ]);
    }
}

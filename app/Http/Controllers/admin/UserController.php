<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::latest();

        if(!empty($request->get('keyword'))){
            $keyword = $request->get('keyword');
            $users = $users->where(function($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%")
                      ->orWhere('email', 'like', "%$keyword%");
            });

        }
        $users = $users->paginate(10);

        return view('admin.user.list',
            [
                'users' => $users,
            ]);
    }

    public function create(Request $request)
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->role = 'user';
            $user->status = $request->status;
            $user->save();
            session()->flash('success', 'User created successfully');
            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        if(empty($user)){
            $message = 'User not found';
            session()->flash('error', $message);
            return redirect()->route('users.index');
        }
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if(empty($user)){
            $message = 'User not found';
            session()->flash('error', $message);
            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id.',id',
            'phone' => 'required|string|max:15',
        ]);
        if ($validator->passes()) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->status = $request->status;
            if($request->password){
                $user->password = Hash::make($request->password);
            }
            $user->save();

            session()->flash('success', 'User updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'User updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        if(empty($user)){
            $message = 'User not found';
            session()->flash('error', $message);
            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        }
        $user->delete();
        session()->flash('success', 'User deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully',
        ]);
    }
}

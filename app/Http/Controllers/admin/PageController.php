<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $pages = Page::latest();
        if($request->keyword != '') {
            $pages = $pages->where('name', 'like', '%' . $request->keyword . '%');
        }

        $pages = $pages->paginate(10);
        return view('admin.page.list', compact('pages'));
    }
    public function create(Request $request)
    {
        return view('admin.page.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:pages,slug',
        ]);
        if ($validator->passes()) {
            $page = new Page();
            $page->name = $request->name;
            $page->slug = $request->slug;
            $page->content = $request->input('content');
            $page->save();
            session()->flash('success', 'Page Content created successfully');
            return response()->json([
                'status' => true,
                'message' => 'Page Content created successfully',
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
        $page = Page::find($id);
        if($page == null) {
            session()->flash('error', 'Page not found');
            return redirect()->route('admin.page.index');
        }
        return view('admin.page.edit', compact('page'));
    }
    public function update(Request $request, $id)
    {
        $page = Page::find($id);
        if($page == null) {
            session()->flash('error', 'Page not found');
            return response()->json([
                'status' => true,
            ]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:pages,slug',
        ]);
        if ($validator->passes()) {
            $page->name = $request->name;
            $page->slug = $request->slug;
            $page->content = $request->input('content');
            $page->save();
            session()->flash('success', 'Page Content updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'Page Content updated successfully',
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
        $page = Page::find($id);
        if(empty($page)){
            $message = 'Page not found';
            session()->flash('error', $message);
            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        }
        $page->delete();
        session()->flash('success', 'Page deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Page deleted successfully',
        ]);
    }
}

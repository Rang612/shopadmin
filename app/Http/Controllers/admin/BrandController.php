<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::latest('id');
        if($request->get('keyword')){
            $brands = $brands->where('name', 'like', '%'.$request->get('keyword').'%');
        }
        $brands = $brands->paginate(10);
        return view('admin.brand.list', compact('brands'));

    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:brands',
        ]);

        if ($validator->passes()) {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            return response()->json([
                'status' => true,
                'message' => 'Brand created successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

        public function edit($id, Request $request)
        {
            $brand = Brand::find($id);
            if(empty($brand)){
                $request->session()->flash('error', 'Brand not found');
                return redirect()->route('brands.index');
            }
            $data['brand'] = $brand;
            return view('admin.brand.edit', $data);
        }

        public function update($id, Request $request)
        {
            try {
                $brand = Brand::find($id);
                if(empty($brand)){
                    $request->session()->flash('error', 'Brand not found');
                    return response()->json([
                        'status' => false,
                        'notFound' => true,
                        'message' => 'Brand not found'
                    ]);
                }
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'slug' => 'required|unique:brands,slug,'.$brand->id. ',id',
                ]);
                if ($validator->passes()) {
                    $brand->name = $request->name;
                    $brand->slug = $request->slug;
                    $brand->status = $request->status;
                    $brand->save();
                    return response()->json([
                        'status' => true,
                        'message' => 'Brand updated successfully'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'errors' => $validator->errors()
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        public function destroy($id, Request $request)
        {
            $brand = Brand::find($id);
            if(empty($brand)){
                return redirect()->route('brands.index');
            }
            $brand->delete();
            return response()->json([
                'status' => true,
                'message' => 'Brand deleted successfully'
            ]);
        }


}

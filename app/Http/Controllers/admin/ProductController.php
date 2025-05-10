<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::latest('id')->with('product_images');
        if(!empty($request->get('keyword'))){
            $products = $products->where('title', 'like', '%'.$request->get('keyword').'%');
        }
        $products = $products->paginate();
        $data['products'] = $products ;
        return view('admin.product.list', $data);
    }
    public function create()
    {
        $data = [];
        $categories = Category::orderBy('name','ASC')->get();
        $brands = Brand::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        return view('admin.product.create', $data);
    }

//    public function store(Request $request)
//    {
//        $rules= [
//            'title'=>'required',
//            'slug'=>'required|unique:products',
//            'price'=>'required|numeric',
//            'sku'=>'required|unique:products',
//            'track_qty'=>'required|in:Yes,No',
//            'category'=>'required|numeric',
//            'is_featured'=>'required|in:Yes,No',
//        ];
//
//        if(!empty($request->track_qty) && $request->track_qty == 'Yes'){
//            $rules['qty'] = 'required|numeric';
//        }
//        $validator = Validator::make($request->all(),$rules);
//
//        if($validator->passes()){
//            $product = new Product();
//            $product->title = $request->title;
//            $product->slug = $request->slug;
//            $product->description = $request->description;
//            $product->price = $request->price;
//            $product->compare_price = $request->compare_price;
//            $product->sku = $request->sku;
//            $product->barcode = $request->barcode;
//            $product->track_qty = $request->track_qty;
//            $product->qty = $request->qty;
//            $product->status = $request->status;
//            $product->category_id = $request->category;
//            $product->sub_category_id = $request->sub_category;
//            $product->brand_id = $request->brand;
//            $product->is_featured = $request->is_featured;
//            $product->save();
//
//            if ($request->has('tags')) {
//                $tagIds = [];
//                foreach ($request->tags as $tagName) {
//                    $tag = Tag::firstOrCreate(
//                        ['name' => $tagName],
//                        ['slug' => Str::slug($tagName)]
//                    );
//                    $tagIds[] = $tag->id;
//                }
//                $product->tags()->sync($tagIds);
//            }
//
//            if ($request->has('variants')) {
//                foreach ($request->variants as $variant) {
//                    $product->productDetail()->create([
//                        'color' => $variant['color'],
//                        'size' => $variant['size'],
//                        'qty' => $variant['qty'],
//                    ]);
//                }
//            }
//
//                $totalQty = $product->productDetail()->sum('qty');
//                $product->qty = $totalQty;
//                $product->save();
//            //Save Gallery Images
//
//            if(!empty($request->image_array)){
//                $imgurClient = new \GuzzleHttp\Client();
//                $imgurClientId = env('IMGUR_CLIENT_ID');
//
//                foreach ($request->image_array as $temp_image_id){
//
//                    $tempImageInfo = TempImage::find($temp_image_id);
//                    $extArray = explode('.',$tempImageInfo->name);
//                    $ext = last($extArray);
//
//                    $productImage = new ProductImage();
//                    $productImage->product_id = $product->id;
//                    $productImage->image = 'NULL';
//                    $productImage->save();
//
//                    $imageName = $product->id.'-'.$productImage->id.'-'.time().'.'.$ext;
//                    $productImage->image = $imageName;
//                    $productImage->save();
//
//                    //Generate Product thumbnail
//
//                    //Large Image
//                    $sourcePath = public_path().'/temp/'.$tempImageInfo->name;
//                    $destPath = public_path().'/upload/product/large/'.$imageName;
//                    $image = Image::make($sourcePath);
//                    $image->resize(1400, null, function($constraint){
//                        $constraint->aspectRatio();
//                    });
//                    $image->save($destPath);
//                    //small Image
////                    $sourcePath = public_path().'/temp/'.$tempImageInfo->name;
//                    $destPath = public_path().'/upload/product/small/'.$imageName;
//                    $image = Image::make($sourcePath);
//                    $image->fit(300,300);
//                    $image->save($destPath);
//
//
//                    // **Upload ảnh lên Imgur**
//                    $response = $imgurClient->request('POST', 'https://api.imgur.com/3/image', [
//                        'headers' => [
//                            'Authorization' => 'Client-ID ' . $imgurClientId,
//                        ],
//                        'form_params' => [
//                            'image' => base64_encode(file_get_contents($sourcePath)),
//                        ],
//                    ]);
//
//                    $imgurData = json_decode($response->getBody()->getContents(), true);
//
//                    if ($imgurData['success']) {
//                        $productImage->imgur_link = $imgurData['data']['link']; // Lưu link ảnh trên Imgur
//                        $productImage->imgur_deletehash = $imgurData['data']['deletehash']; // Lưu deletehash để xóa sau này
//                        $productImage->save();
//                    }
//                }
//            }
//
//            $request->session()->flash('success', 'Product added successfully');
//
//            return response()->json([
//                'status'=>true,
//                'message'=> 'Product added successfully'
//            ]);
//        } else{
//            return response()->json([
//                'status'=>false,
//                'error'=>$validator->errors()
//            ]);
//
//        }
//    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        }

        $product = new Product();
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->track_qty = $request->track_qty;
        $product->qty = $request->qty;
        $product->status = $request->status;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->brand_id = $request->brand;
        $product->is_featured = $request->is_featured;
        $product->save();

        // Tags
        if ($request->has('tags')) {
            $tagIds = [];
            foreach ($request->tags as $tag) {
                $tagName = is_numeric($tag) ? Tag::find($tag)->name : str_replace('new:', '', $tag);
                $tagModel = Tag::firstOrCreate(['name' => $tagName], ['slug' => Str::slug($tagName)]);
                $tagIds[] = $tagModel->id;
            }
            $product->tags()->sync($tagIds);
        }

        // Variants
        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                $product->productDetail()->create([
                    'color' => $variant['color'],
                    'size' => $variant['size'],
                    'qty' => $variant['qty'],
                ]);
            }
        }

        // Tổng số lượng
        $product->qty = $product->productDetail()->sum('qty');
        $product->save();

        // Tạo thư mục shared nếu chưa có
        $sharedLargePath = public_path('uploads/products/large/');
        $sharedSmallPath = public_path('uploads/products/small/');
        if (!File::exists($sharedLargePath)) File::makeDirectory($sharedLargePath, 0755, true);
        if (!File::exists($sharedSmallPath)) File::makeDirectory($sharedSmallPath, 0755, true);

        // Lưu ảnh sản phẩm
        if (!empty($request->image_array)) {
            foreach ($request->image_array as $temp_image_id) {
                $tempImageInfo = TempImage::find($temp_image_id);
                if (!$tempImageInfo) continue;

                $ext = pathinfo($tempImageInfo->name, PATHINFO_EXTENSION);

                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image = 'NULL';
                $productImage->save();

                $imageName = $product->id . '-' . $productImage->id . '-' . time() . '.' . $ext;
                $productImage->image = $imageName;
                $productImage->save();

                $sourcePath = public_path('temp/' . $tempImageInfo->name);

                // Large
                Image::make($sourcePath)->resize(1400, null, function ($c) {
                    $c->aspectRatio();
                })->save($sharedLargePath . $imageName);

                // Small
                Image::make($sourcePath)->fit(300, 300)->save($sharedSmallPath . $imageName);
            }
        }

        $request->session()->flash('success', 'Product added successfully');

        return response()->json([
            'status' => true,
            'message' => 'Product added successfully'
        ]);
    }

    public function edit($id, Request $request)
    {
        $product = Product::with(['productDetail', 'tags'])->find($id);
        if(empty($product)){
            return redirect()->route('products.index')->with('error', 'Product not found');
        }
        //fetch product images
        $productImages = ProductImage::where('product_id', $product->id)->get();

        $sub_categories = SubCategory::where('category_id', $product->category_id)->get();
        $productTags = $product->tags()->pluck('name')->unique()->toArray();
//        dd($productTags);

        $data = [];
        $categories = Category::orderBy('name','ASC')->get();
        $brands = Brand::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['product'] = $product;
        $data['sub_categories'] = $sub_categories;
        $data['productImages'] = $productImages;
        $data['productTags'] = $productTags;
        $data['productDetails'] = $product->productDetail;
        return view('admin.product.edit', $data);
    }

//    public function update($id, Request $request)
//    {
//        $product = Product::find($id);
//        $rules= [
//            'title'=>'required',
//            'slug'=>'required|unique:products,slug,'.$product->id. ',id',
//            'price'=>'required|numeric',
//            'sku'=>'required|unique:products,sku,'.$product->id. ',id',
//            'track_qty'=>'required|in:Yes,No',
//            'category'=>'required|numeric',
//            'is_featured'=>'required|in:Yes,No',
//        ];
//
//        if(!empty($request->track_qty) && $request->track_qty == 'Yes'){
//            $rules['qty'] = 'required|numeric';
//        }
//        $validator = Validator::make($request->all(),$rules);
//
//        if($validator->passes()){
//            $product->title = $request->title;
//            $product->slug = $request->slug;
//            $product->description = $request->description;
//            $product->price = $request->price;
//            $product->compare_price = $request->compare_price;
//            $product->sku = $request->sku;
//            $product->barcode = $request->barcode;
//            $product->track_qty = $request->track_qty;
//            $product->qty = $request->qty;
//            $product->status = $request->status;
//            $product->category_id = $request->category;
//            $product->sub_category_id = $request->sub_category;
//            $product->brand_id = $request->brand;
//            $product->is_featured = $request->is_featured;
//            $product->save();
//
//// Cập nhật thông tin sản phẩm
//            $product->update($request->except('tags'));
//
//            // ✅ Xử lý tags khi cập nhật
//            if ($request->has('tags')) {
//                $tagIds = [];
//
//                foreach ($request->tags as $tag) {
//                    if (is_numeric($tag)) { // Nếu tag đã tồn tại trong DB
//                        $tagIds[] = $tag;
//                    } else { // Nếu tag là chuỗi mới
//                        $tagName = str_replace('new:', '', $tag); // Xóa tiền tố 'new:'
//                        $newTag = Tag::firstOrCreate(
//                            ['name' => $tagName],
//                            ['slug' => Str::slug($tagName)]
//                        );
//                        $tagIds[] = $newTag->id;
//                    }
//                }
//
//                $product->tags()->sync($tagIds); // Đồng bộ tags
//            }
//            $submittedIds = [];
//
//            if ($request->has('variants')) {
//                foreach ($request->variants as $variant) {
//                    if (!empty($variant['id'])) {
//                        // UPDATE
//                        ProductDetail::where('id', $variant['id'])
//                            ->where('product_id', $product->id)
//                            ->update([
//                                'color' => $variant['color'],
//                                'size' => $variant['size'],
//                                'qty' => $variant['qty'],
//                            ]);
//                        $submittedIds[] = $variant['id'];
//                    } else {
//                        // CREATE
//                        $newDetail = $product->productDetail()->create([
//                            'color' => $variant['color'],
//                            'size' => $variant['size'],
//                            'qty' => $variant['qty'],
//                        ]);
//                        $submittedIds[] = $newDetail->id;
//                    }
//                }
//            }
//
//// DELETE những dòng không còn trong form
//            $product->productDetail()->whereNotIn('id', $submittedIds)->delete();
//
//            $totalQty = $product->productDetail()->sum('qty');
//            $product->qty = $totalQty;
//            $product->save();
//            $request->session()->flash('success', 'Product updated successfully');
//
//            return response()->json([
//                'status'=>true,
//                'message'=> 'Product added successfully'
//            ]);
//        } else{
//            return response()->json([
//                'status'=>false,
//                'error'=>$validator->errors()
//            ]);
//
//        }
//
//    }

    public function update($id, Request $request)
    {
        $product = Product::find($id);
        $rules = [
            'title'=>'required',
            'slug'=>'required|unique:products,slug,'.$product->id.',id',
            'price'=>'required|numeric',
            'sku'=>'required|unique:products,sku,'.$product->id.',id',
            'track_qty'=>'required|in:Yes,No',
            'category'=>'required|numeric',
            'is_featured'=>'required|in:Yes,No',
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        }

        $product->fill($request->except('tags', 'variants'));
        $product->save();

        // Tags
        if ($request->has('tags')) {
            $tagIds = [];
            foreach ($request->tags as $tag) {
                $tagName = is_numeric($tag) ? Tag::find($tag)->name : str_replace('new:', '', $tag);
                $tagModel = Tag::firstOrCreate(['name' => $tagName], ['slug' => Str::slug($tagName)]);
                $tagIds[] = $tagModel->id;
            }
            $product->tags()->sync($tagIds);
        }

        // Variants
        $submittedIds = [];
        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                if (!empty($variant['id'])) {
                    ProductDetail::where('id', $variant['id'])->where('product_id', $product->id)->update([
                        'color' => $variant['color'],
                        'size' => $variant['size'],
                        'qty' => $variant['qty'],
                    ]);
                    $submittedIds[] = $variant['id'];
                } else {
                    $newDetail = $product->productDetail()->create([
                        'color' => $variant['color'],
                        'size' => $variant['size'],
                        'qty' => $variant['qty'],
                    ]);
                    $submittedIds[] = $newDetail->id;
                }
            }
        }

        $product->productDetail()->whereNotIn('id', $submittedIds)->delete();

        // Tổng lại số lượng
        $product->qty = $product->productDetail()->sum('qty');
        $product->save();

        // Xử lý ảnh mới
        $sharedLargePath = public_path('uploads/products/large/');
        $sharedSmallPath = public_path('uploads/products/small/');
        if (!File::exists($sharedLargePath)) File::makeDirectory($sharedLargePath, 0755, true);
        if (!File::exists($sharedSmallPath)) File::makeDirectory($sharedSmallPath, 0755, true);

        if (!empty($request->image_array)) {
            foreach ($request->image_array as $temp_image_id) {
                $tempImageInfo = TempImage::find($temp_image_id);
                if (!$tempImageInfo) continue;

                $ext = pathinfo($tempImageInfo->name, PATHINFO_EXTENSION);

                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image = 'NULL';
                $productImage->save();

                $imageName = $product->id . '-' . $productImage->id . '-' . time() . '.' . $ext;
                $productImage->image = $imageName;
                $productImage->save();

                $sourcePath = public_path('temp/' . $tempImageInfo->name);

                Image::make($sourcePath)->resize(1400, null, function ($c) {
                    $c->aspectRatio();
                })->save($sharedLargePath . $imageName);

                Image::make($sourcePath)->fit(300, 300)->save($sharedSmallPath . $imageName);
            }
        }

        $request->session()->flash('success', 'Product updated successfully');

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully'
        ]);
    }


//    public function destroy($id, Request $request)
//    {
//        $product = Product::find($id);
//        if(empty($product)){
//            $request -> session()->flash('error', 'Product not found');
//            return response()->json([
//                'status'=>false,
//                'notFound'=>true
//            ]);
//        }
//
//        // Xóa các bản ghi liên quan
//        ProductComment::where('product_id', $id)->delete();
//        ProductDetail::where('product_id', $id)->delete();
//        ProductTag::where('product_id', $id)->delete();
//        $productImages = ProductImage::where('product_id', $id)->get();
//
//        if(!empty($productImages)){
//            $imgurClient = new \GuzzleHttp\Client();
//            $imgurClientId = env('IMGUR_CLIENT_ID');
//            foreach ($productImages as $productImage){
//                // **Xóa ảnh trên Imgur**
//                if (!empty($productImage->imgur_deletehash)) {
//                    $imgurClient->request('DELETE', 'https://api.imgur.com/3/image/' . $productImage->imgur_deletehash, [
//                        'headers' => [
//                            'Authorization' => 'Client-ID ' . $imgurClientId,
//                        ],
//                    ]);
//                }
//                File::delete(public_path('upload/product/large/'.$productImage->image));
//                File::delete(public_path('upload/product/small/'.$productImage->image));
//
//                $productImage->delete();
//
//            }
//
//            ProductImage::where('product_id', $id)->delete();
//
//        }
//        $product->delete();
//
//        $request -> session()->flash('success', 'Product deleted successfully');
//            return response()->json([
//                'status'=>false,
//                'message'=>'Product deleted successfully'
//            ]);
//    }

    public function destroy($id, Request $request)
    {
        $product = Product::find($id);
        if (empty($product)) {
            $request->session()->flash('error', 'Product not found');
            return response()->json([
                'status' => false,
                'notFound' => true
            ]);
        }

        // Xoá liên kết
        ProductComment::where('product_id', $id)->delete();
        ProductDetail::where('product_id', $id)->delete();
        ProductTag::where('product_id', $id)->delete();

        // Xoá ảnh
        $productImages = ProductImage::where('product_id', $id)->get();
        foreach ($productImages as $img) {
            File::delete([
                public_path('uploads/products/large/' . $img->image),
                public_path('uploads/products/small/' . $img->image)
            ]);
            $img->delete();
        }

        $product->delete();

        $request->session()->flash('success', 'Product deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    public function getTags(Request $request)
    {
        $search = $request->input('q');

        $tags = Tag::where('name', 'LIKE', "%{$search}%")
            ->select('id', 'name as text') // Select đúng format cho select2
            ->get();

        return response()->json(['tags' => $tags]);
    }

}

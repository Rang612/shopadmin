<?php


namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImage;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
        public function index(Request $request)
    {
        $categories = Category::latest();

        if(!empty($request->get('keyword'))){
            $categories = $categories->where('name', 'like', '%'.$request->get('keyword').'%');
        }
        $categories = $categories->paginate(10);
        return view('admin.category.list', compact('categories'));
    }


    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.category.create');
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'slug' => 'required|unique:product_categories',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }

            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->image = 'NULL'; // Giá trị mặc định
            $category->save();

            // Save image
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                if ($tempImage) {
                    $extArray = explode('.', $tempImage->name);
                    $ext = end($extArray);

                    $imgurClient = new Client();
                    $imgurClientId = env('IMGUR_CLIENT_ID');

                    $newImageName = $category->id . '.' . $ext;
                    $sPath = public_path('temp/' . $tempImage->name);
                    $dPath = public_path('upload/category/' . $newImageName);

                    // Ensure the destination directory exists
                    if (!File::exists(public_path('upload/category'))) {
                        File::makeDirectory(public_path('upload/category'), 0755, true);
                    }

                    // Copy the file
                    if (File::copy($sPath, $dPath)) {
                        $dPath = public_path('upload/category/thumb/' . $newImageName);
                        $img = Image::make($sPath);
                        $img->fit(450, 600, function ($constraint) {
                            $constraint->upsize();
                        });
                        $img->save($dPath);


                        $category->image = $newImageName;
                        $category->save();

                        $response = $imgurClient->request('POST', 'https://api.imgur.com/3/image', [
                            'headers' => [
                                'Authorization' => 'Client-ID ' . $imgurClientId,
                            ],
                            'form_params' => [
                                'image' => base64_encode(file_get_contents($sPath)),
                            ],
                        ]);

                        $imgurData = json_decode($response->getBody()->getContents(), true);

                        if ($imgurData['success']) {
                            $category->image = $imgurData['data']['link'];
                            $category->imgur_deletehash = $imgurData['data']['deletehash'];
                            $category->save();
                        }
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Failed to copy the image'
                        ]);
                    }
                }
            }

            $request->session()->flash('success', 'Category created successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function edit($categoryId, Request $request){
        $category = Category::find($categoryId);
        if(empty($category)){
            return redirect()->route('categories.index');
        }

        return view('admin.category.edit', compact('category'));
    }

    public function update($categoryId, Request $request)
    {
        try {
            $category = Category::find($categoryId);
            if(empty($category)){
                $request->session()->flash('error', 'Category not found');

                return response()->json([
                    'status' => false,
                    'notFound' => true,
                    'message' => 'Category not found'
                ]);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'slug' => 'required|unique:product_categories,slug,'.$category->id. ',id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
//            $category->image = 'NULL'; // Giá trị mặc định
            $category->save();

            $oldImage = $category->image;
            // Save image
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                if ($tempImage) {
                    $extArray = explode('.', $tempImage->name);
                    $ext = end($extArray);

                    $newImageName = $category->id . '-'.time().'.' . $ext;
                    $sPath = public_path('temp/' . $tempImage->name);
                    $dPath = public_path('upload/category/' . $newImageName);

                    // Ensure the destination directory exists
                    if (!File::exists(public_path('upload/category'))) {
                        File::makeDirectory(public_path('upload/category'), 0755, true);
                    }

                    // Copy the file
                    if (File::copy($sPath, $dPath)) {
                        $dPath = public_path('upload/category/thumb/' . $newImageName);
                        $img = Image::make($sPath);
                        $img->fit(450, 600, function ($constraint) {
                            $constraint->upsize();
                        });
                        $img->save($dPath);


                        $category->image = $newImageName;
                        $category->save();

                        File::delete(public_path('upload/category/thumb/' . $oldImage));
                        File::delete(public_path('upload/category/' . $oldImage));

                        // Upload ảnh mới lên Imgur nếu có
                        if (!empty($request->image_id)) {
                            $tempImage = TempImage::find($request->image_id);
                            if ($tempImage) {
                                $sourcePath = public_path('temp/' . $tempImage->name);

                                $imgurClient = new Client();
                                $imgurClientId = env('IMGUR_CLIENT_ID');

                                // Xóa ảnh cũ trên Imgur (nếu có)
                                if (!empty($category->imgur_deletehash)) {
                                    $imgurClient->request('DELETE', 'https://api.imgur.com/3/image/' . $category->imgur_deletehash, [
                                        'headers' => [
                                            'Authorization' => 'Client-ID ' . $imgurClientId,
                                        ],
                                    ]);
                                }

                                // Upload ảnh mới
                                $response = $imgurClient->request('POST', 'https://api.imgur.com/3/image', [
                                    'headers' => [
                                        'Authorization' => 'Client-ID ' . $imgurClientId,
                                    ],
                                    'form_params' => [
                                        'image' => base64_encode(file_get_contents($sourcePath)),
                                    ],
                                ]);

                                $imgurData = json_decode($response->getBody()->getContents(), true);

                                if ($imgurData['success']) {
                                    $category->imgur_link = $imgurData['data']['link'];
                                    $category->imgur_deletehash = $imgurData['data']['deletehash'];
                                    $category->save();
                                }
                            }
                        }
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Failed to copy the image'
                        ]);
                    }
                }
            }

            $request->session()->flash('success', 'Category updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($categoryId, Request $request)
    {
        $category = Category::find($categoryId);
        if(empty($category)){
            return redirect()->route('categories.index');
        }
        File::delete(public_path('upload/category/thumb/' . $category->image));
        File::delete(public_path('upload/category/' .  $category->image));

        // **Xóa ảnh trên Imgur nếu có**
        if (!empty($category->imgur_deletehash)) {
            $client = new Client();
            $clientId = env('IMGUR_CLIENT_ID');

            $client->request('DELETE', 'https://api.imgur.com/3/image/' . $category->imgur_deletehash, [
                'headers' => [
                    'Authorization' => 'Client-ID ' . $clientId,
                ],
            ]);
        }

        $category->delete();

        $request->session()->flash('success', 'Category deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}

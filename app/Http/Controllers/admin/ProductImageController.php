<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProductImageController extends Controller
{
    protected $imgurClient;
    protected $imgurClientId;

    public function __construct()
    {
        $this->imgurClient = new Client();
        $this->imgurClientId = env('IMGUR_CLIENT_ID'); // Lấy Client ID từ .env
    }
    public function update(Request $request)
    {
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $sourcePath = $image->getPathName();

        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL';
        $productImage->save();

        $imageName =$request->product_id.'-'.$productImage->id.'-'.time().'.'.$ext;
        $productImage->image = $imageName;
        $productImage->save();

        //Large Image
        $destPath = public_path().'/upload/product/large/'.$imageName;
        $image = Image::make($sourcePath);
        $image->resize(1400, null, function($constraint){
            $constraint->aspectRatio();
        });
        $image->save($destPath);
        //small Image
//                    $sourcePath = public_path().'/temp/'.$tempImageInfo->name;
        $destPath = public_path().'/upload/product/small/'.$imageName;
        $image = Image::make($sourcePath);
        $image->fit(300,300);
        $image->save($destPath);

        // **Upload ảnh lên Imgur**
        $response = $this->imgurClient->request('POST', 'https://api.imgur.com/3/image', [
            'headers' => [
                'Authorization' => 'Client-ID ' . $this->imgurClientId,
            ],
            'form_params' => [
                'image' => base64_encode(file_get_contents($sourcePath)),
            ],
        ]);

        $imgurData = json_decode($response->getBody()->getContents(), true);

        if ($imgurData['success']) {
            $productImage->imgur_link = $imgurData['data']['link']; // Lưu link ảnh trên Imgur
            $productImage->imgur_deletehash = $imgurData['data']['deletehash']; // Lưu deletehash để xóa sau này
            $productImage->save();
        }
        return response()->json([
            'status'=>true,
            'image_id'=> $productImage->id,
            'ImagePath'=> asset('upload/product/small/'.$productImage->image),
            'message'=> 'Product Image saved successfully'
        ]);
    }

    public function destroy(Request $request)
    {
        $productImage = ProductImage::find($request->id);

        if(empty($productImage)){
            return response()->json([
                'status'=>false,
                'message'=> 'Product Image not found'
            ]);

        }
        // **Xóa ảnh trên Imgur**
        if (!empty($productImage->imgur_deletehash)) {
            $this->imgurClient->request('DELETE', 'https://api.imgur.com/3/image/' . $productImage->imgur_deletehash, [
                'headers' => [
                    'Authorization' => 'Client-ID ' . $this->imgurClientId,
                ],
            ]);
        }
        //Delete Image from folder
         File::delete(public_path('/upload/product/large/'.$productImage->image));
         File::delete(public_path('/upload/product/small/'.$productImage->image));

        $productImage->delete();

        return response()->json([
            'status'=>true,
            'message'=> 'Product Image deleted successfully'
        ]);
    }
}

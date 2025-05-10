<?php
//
//namespace App\Http\Controllers\admin;
//
//use App\Http\Controllers\Controller;
//use App\Models\TempImage;
//use Illuminate\Http\Request;
//use Intervention\Image\Facades\Image;
//
//class TempImagesController extends Controller
//{
//    public function create(Request $request)
//    {
//        $image = $request->image;
//
//        if (!empty($image)) {
//            $ext = $image->getClientOriginalExtension();
//            $newName = time() . '.' . $ext;
//
//            $tempImage = new TempImage();
//            $tempImage->name = $newName;
//            $tempImage->save();
//
//            $image->move(public_path().'/temp', $newName);
//
//            //Generate thumbnail
//            $sourcePath = public_path().'/temp/'.$newName;
//            $destPath = public_path().'/temp/thumb/'.$newName;
//            $image = Image::make($sourcePath);
//            $image->fit(300,275);
//            $image->save($destPath);
//            return response()->json([
//                'status' => true,
//                'image_id' => $tempImage->id,
//                'ImagePath' => asset('/temp/thumb/'.$newName),
//                'message' => 'Image uploaded successfully'
//            ]);
//        }
//
//    }
//}

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class TempImagesController extends Controller
{
    public function create(Request $request)
    {
        $image = $request->image;

        if (!empty($image)) {
            $ext = $image->getClientOriginalExtension();
            $newName = time() . '-' . uniqid() . '.' . $ext;

            $tempImage = new TempImage();
            $tempImage->name = $newName;
            $tempImage->save();

            // Đường dẫn shared_uploads
            $sharedPath = public_path('uploads/temp');
            $thumbPath = $sharedPath . '/thumb';

            // Tạo thư mục nếu chưa có
            if (!File::exists($sharedPath)) {
                File::makeDirectory($sharedPath, 0755, true);
            }
            if (!File::exists($thumbPath)) {
                File::makeDirectory($thumbPath, 0755, true);
            }

            // Di chuyển ảnh gốc
            $image->move($sharedPath, $newName);

            // Tạo thumbnail
            $sourcePath = $sharedPath . '/' . $newName;
            $thumbFullPath = $thumbPath . '/' . $newName;

            $thumbnail = Image::make($sourcePath)->fit(300, 275);
            $thumbnail->save($thumbFullPath);

            return response()->json([
                'status' => true,
                'image_id' => $tempImage->id,
                'ImagePath' => asset('uploads/temp/thumb/' . $newName),
                'message' => 'Image uploaded successfully'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'No image provided'
        ]);
    }
}

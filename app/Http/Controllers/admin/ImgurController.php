<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ImgurController extends Controller
{
    protected $client;
    protected $clientId;

    public function __construct()
    {
        $this->client = new Client();
        $this->clientId = env('IMGUR_CLIENT_ID'); // Lấy Client ID từ .env
    }

    /**
     * Upload ảnh lên Imgur
     */
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // Giới hạn ảnh tối đa 5MB
        ]);

        $image = $request->file('image');
        $imagePath = $image->getPathName(); // Lấy đường dẫn ảnh tạm thời

        $response = $this->client->request('POST', 'https://api.imgur.com/3/image', [
            'headers' => [
                'Authorization' => 'Client-ID ' . $this->clientId,
            ],
            'form_params' => [
                'image' => base64_encode(file_get_contents($imagePath)),
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['success']) {
            return response()->json([
                'status' => true,
                'link' => $data['data']['link'],
                'deletehash' => $data['data']['deletehash'],
                'message' => 'Upload ảnh thành công!',
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Upload thất bại'], 500);
    }

    /**
     * Xóa ảnh trên Imgur bằng Delete Hash
     */
    public function delete(Request $request)
    {
        $request->validate([
            'deletehash' => 'required|string',
        ]);

        $deleteHash = $request->deletehash;

        $response = $this->client->request('DELETE', "https://api.imgur.com/3/image/{$deleteHash}", [
            'headers' => [
                'Authorization' => 'Client-ID ' . $this->clientId,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['success']) {
            return response()->json([
                'status' => true,
                'message' => 'Xóa ảnh thành công!',
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Xóa ảnh thất bại'], 500);
    }
}

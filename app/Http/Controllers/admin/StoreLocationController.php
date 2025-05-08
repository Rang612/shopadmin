<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreLocation;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\StoreLocation::query();

        // Tìm theo tên hoặc thành phố
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('city', 'like', '%' . $request->keyword . '%');
        }

        $stores = $query->orderByDesc('is_featured')->paginate(10)->withQueryString();

        return view('super_admin.store.list', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.store.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $store = new StoreLocation();
        $store->name = $request->name;
        $store->address = $request->address;
        $store->city = $request->city;
        $store->phone = $request->phone;
        $store->opening_hours = $request->opening_time . ' - ' . $request->closing_time;
        $store->latitude = $request->latitude;
        $store->longitude = $request->longitude;
        $store->is_featured = $request->is_featured ?? 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('upload/store_location', $fileName, 'public');
            $store->image = $fileName;

            // Upload lên Imgur
            $client = new Client();
            $response = $client->request('POST', 'https://api.imgur.com/3/image', [
                'headers' => [
                    'Authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
                ],
                'form_params' => [
                    'image' => base64_encode(file_get_contents($image->getPathname())),
                ],
            ]);

            $imgur = json_decode($response->getBody()->getContents(), true);

            if ($imgur['success']) {
                $store->image_url = $imgur['data']['link'];
                $store->image_deletehash = $imgur['data']['deletehash'];
            }
        }

        $store->save();

        return redirect()->route('store_location.index')
            ->with('success', 'Store created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $store = StoreLocation::findOrFail($id);

        // Nếu bạn lưu giờ vào 1 chuỗi opening_hours, cần tách ra
        $times = explode(' - ', $store->opening_hours);
        $opening_time = $times[0] ?? '';
        $closing_time = $times[1] ?? '';

        return view('super_admin.store.edit', compact('store', 'opening_time', 'closing_time'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $store = StoreLocation::findOrFail($id);
        $store->fill($request->only([
            'name', 'address', 'city', 'phone', 'latitude', 'longitude', 'is_featured'
        ]));

        $store->opening_hours = $request->opening_time . ' - ' . $request->closing_time;

        // Nếu có ảnh mới
        if ($request->hasFile('image')) {
            // Xoá ảnh local cũ nếu có
            if ($store->image && Storage::disk('public')->exists($store->image)) {
                Storage::disk('public')->delete($store->image);
            }

            // Xoá ảnh Imgur cũ nếu có deletehash
            if ($store->image_deletehash) {
                try {
                    $client = new Client();
                    $client->request('DELETE', 'https://api.imgur.com/3/image/' . $store->image_deletehash, [
                        'headers' => [
                            'Authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
                        ],
                    ]);
                } catch (\Exception $e) {
                    // Không cần xử lý lỗi Imgur ở đây
                }
            }

            // ✅ Upload ảnh mới
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('upload/store_location', $fileName, 'public');
            $store->image = $fileName;
            $client = new \GuzzleHttp\Client();

            // ✅ Upload lên Imgur
            $res = $client->request('POST', 'https://api.imgur.com/3/image', [
                'headers' => ['Authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID')],
                'form_params' => ['image' => base64_encode(file_get_contents($image->getPathname()))]
            ]);

            $imgur = json_decode($res->getBody(), true);
            if ($imgur['success']) {
                $store->image_url = $imgur['data']['link'];
                $store->image_deletehash = $imgur['data']['deletehash'];
            }
        }

        $store->save();

        return redirect()->route('store_location.index')
            ->with('success', 'Store updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $store = StoreLocation::findOrFail($id);

        // Xoá ảnh local
        if ($store->image && Storage::disk('public')->exists($store->image)) {
            Storage::disk('public')->delete($store->image);
        }

        // Xoá ảnh Imgur nếu có
        if ($store->image_deletehash) {
            try {
                $client = new \GuzzleHttp\Client();
                $client->request('DELETE', 'https://api.imgur.com/3/image/' . $store->image_deletehash, [
                    'headers' => [
                        'Authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
                    ],
                ]);
            } catch (\Exception $e) {
                // Imgur xoá lỗi không sao
            }
        }

        $store->delete();

        return response()->json(['status' => true]);
    }

}

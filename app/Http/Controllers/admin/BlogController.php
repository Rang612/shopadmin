<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::with('blogcomment')->latest()->paginate(10);
        foreach ($blogs as $blog) {
            if ($blog->image_url && $blog->image) {
                $blog->saved_image = $this->downloadAndSaveImage($blog->image_url, $blog->image);
            } elseif ($blog->image) {
                $blog->saved_image = "storage/blogs/{$blog->image}";
            } else {
                $blog->saved_image = 'front/img/default-blog.jpg';
            }
        }
        return view('admin.blogs.list', compact('blogs'));
    }
    private function downloadAndSaveImage($imageUrl, $imageName)
    {
        if (!$imageUrl || !$imageName) {
            return null;
        }

        $path = "public/blogs/{$imageName}";

        if (Storage::exists($path)) {
            return "storage/blogs/{$imageName}";
        }

        $imageContents = @file_get_contents($imageUrl);
        if (!$imageContents) {
            return null;
        }

        Storage::put($path, $imageContents);

        return "storage/blogs/{$imageName}";
    }

    public function approve($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->is_approved = 1;
        $blog->save();

        return redirect()->back()->with('success', 'Article has been approved.');
    }
    public function show($id)
    {
        $blog = Blog::with('user')->findOrFail($id);
        return view('admin.blogs.detail', compact('blog'));
    }
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // Xoá ảnh local nếu có
        if ($blog->image && Storage::disk('public')->exists('blogs/' . $blog->image)) {
            Storage::disk('public')->delete('blogs/' . $blog->image);
        }

        // Xoá ảnh Imgur nếu có
        if ($blog->image_deletehash) {
            $client = new \GuzzleHttp\Client();
            $client->request('DELETE', 'https://api.imgur.com/3/image/' . $blog->image_deletehash, [
                'headers' => [
                    'Authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
                ],
            ]);
        }
        $blog->blogcomment()->delete();
        $blog->delete();
        return redirect()->back()->with('success', 'The post has been deleted.');
    }


    public function deleteComment($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Comment has been deleted.');
    }
}


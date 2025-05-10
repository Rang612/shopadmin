<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::with('blogcomment')->latest()->paginate(10);

        foreach ($blogs as $blog) {
            if ($blog->image) {
                $blog->saved_image = asset('uploads/blogs/' . $blog->image);
            } else {
                $blog->saved_image = asset('front/img/default-blog.jpg');
            }
        }
        return view('admin.blogs.list', compact('blogs'));
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
        $imagePath = public_path('uploads/blogs/' . $blog->image);
        if ($blog->image && File::exists($imagePath)) {
            File::delete($imagePath);
        }
        // Xoá comment và blog
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

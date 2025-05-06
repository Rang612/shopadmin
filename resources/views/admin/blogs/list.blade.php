@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Blogs List</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Status</th>
                <th>Date created</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($blogs as $blog)
                <tr>
                    <td>{{ $blog->id }}</td>
                    <td>{{ $blog->title }}</td>
                    <td>
                        @if($blog->image_url)
                            <img src="{{ asset($blog->saved_image) }}" alt="Ảnh blog" width="150">
                        @else
                            <span class="text-muted">No photo</span>
                        @endif
                    </td>
                    <td>
                        @if($blog->is_approved)
                            <span class="badge badge-success">Approved</span>
                        @else
                            <span class="badge badge-warning">Not approved</span>
                        @endif
                    </td>
                    <td>{{ $blog->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{route('admin.blog.show',$blog->id )}}" class="btn btn-sm btn-info">View</a>
                        @if(!$blog->is_approved)
                            <form action="{{ route('admin.blog.approve', $blog->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-sm btn-success">Approve</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.blog.destroy', $blog->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Xoá bài viết này?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">There are no posts.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $blogs->links() }}
    </div>
@endsection

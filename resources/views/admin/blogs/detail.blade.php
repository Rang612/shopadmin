@extends('admin.layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Blog Detail</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('admin.blog.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <div class="container">
        <h2>{{ $blog->title }}</h2>
        @if($blog->image)
            <img src="{{ asset('storage/blogs/' . $blog->image) }}" width="300" class="mb-3">
        @endif
        <p><strong>Posted by:</strong> {{ $blog->user->name ?? 'No data' }}</p>
        <p><strong>Category:</strong> {{ $blog->category }}</p>
        <p><strong>Quote:</strong> {{ $blog->quote }}</p>
        <p><strong>Content:</strong></p>
        <div>{!!($blog->content)!!}</div>
        <h2 class="mt-4">Comments</h2>

        @if($blog->blogcomment->count())
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Posted At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($blog->blogcomment as $comment)
                    <tr>
                        <td>{{ $comment->name }}</td>
                        <td>{{ $comment->email }}</td>
                        <td>{{ $comment->meassages }}</td>
                        <td>{{ $comment->created_at }}</td>
                        <td>
                            <form action="{{ route('admin.comment.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Xoá comment này?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No comments yet.</p>
        @endif
    </div>
@endsection

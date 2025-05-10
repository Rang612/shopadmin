@extends('admin.layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>List of stores</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('store_location.create')}}" class="btn btn-primary">Add store</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @include('admin.message')
            <div class="card">
                <form action="" method="get">
                    <div class="card-header">
                        <div class="card-title">
                            <button type="button" onclick="window.location.href='{{ route("store_location.index") }}'"
                                    class="btn btn-default btn-sm">All
                            </button>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input value="{{ request()->get('keyword') }}" type="text" name="keyword"
                                       class="form-control float-right" placeholder="Search for name or city">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Opening Hours</th>
                            <th>Featured</th>
                            <th>Image</th>
                            <th width="100">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($stores->isNotEmpty())
                            @foreach($stores as $store)
                                <tr>
                                    <td>{{ $store->name }}</td>
                                    <td>{{ $store->address }}, {{ $store->city }}</td>
                                    <td>{{ $store->phone ?? '-' }}</td>
                                    <td>{{ $store->opening_hours ?? '-' }}</td>
                                    <td>
                                        @if($store->is_featured)
                                            <span class="badge badge-success">Featured</span>
                                        @else
                                            <span class="badge badge-secondary">Normal</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($store->image)
{{--                                            <img src="{{ asset('storage/upload/store_location/' . $store->image) }}" width="60">--}}
                                            <img src="{{ asset($store->image_url) }}" width="60">
                                        @else
                                            Not found
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route ('store_location.edit', $store->id)}}">
                                            <svg class="filament-link-icon w-4 h-4 mr-1"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                 fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </a>
                                        <a href="#" onclick="deleteStore({{ $store->id }})" class="text-danger w-4 h-4 mr-1">
                                            <svg class="filament-link-icon w-4 h-4 mr-1"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                 fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                      clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="8" class="text-center">There are no stores.</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $stores->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        function deleteStore(id) {
            var url = '{{ route("store_location.destroy", ":id") }}'.replace(':id', id);
            if (confirm("Bạn có chắc chắn muốn xoá cửa hàng này?")) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        if (res.status) {
                            window.location.reload();
                        } else {
                            alert("Xoá thất bại.");
                        }
                    }
                });
            }
        }
    </script>
@endsection

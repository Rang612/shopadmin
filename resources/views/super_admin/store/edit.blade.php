@extends('admin.layout.app')

@section('content')
    <div class="container">
        <h3>Edit Store</h3>

        <form action="{{ route('store_location.update', $store->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Store Name</label>
                    <input type="text" name="name" value="{{ old('name', $store->name) }}" class="form-control" required>
                </div>

                <div class="form-group col-md-6">
                    <label>City</label>
                    <input type="text" name="city" value="{{ old('city', $store->city) }}" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Address</label>
                    <input type="text" name="address" value="{{ old('address', $store->address) }}" class="form-control" required>
                </div>

                <div class="form-group col-md-6">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $store->phone) }}" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>Opening Time</label>
                    <input type="time" name="opening_time" value="{{ old('opening_time', $opening_time) }}" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Closing Time</label>
                    <input type="time" name="closing_time" value="{{ old('closing_time', $closing_time) }}" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Latitude</label>
                    <input type="text" name="latitude" value="{{ old('latitude', $store->latitude) }}" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Longitude</label>
                    <input type="text" name="longitude" value="{{ old('longitude', $store->longitude) }}" class="form-control" required>
                </div>
            </div>

            <div class="mb-2">
                <a href="https://www.google.com/maps?q={{ $store->latitude }},{{ $store->longitude }}" target="_blank">
                    📍 Xem vị trí trên bản đồ
                </a>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Featured</label>
                    <select name="is_featured" class="form-control">
                        <option value="0" {{ $store->is_featured ? '' : 'selected' }}>No</option>
                        <option value="1" {{ $store->is_featured ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>Current Image</label><br>
{{--                    @if ($store->image)--}}
{{--                        <img src="{{ asset('storage/upload/store_location/' . $store->image) }}" width="100" class="mb-2"><br>--}}
{{--                    @else--}}
                    @if ($store->image_url)
                        <img src="{{ asset($store->image_url) }}" width="100" class="mb-2"><br>
                    @else
                        <em>No image</em><br>
                    @endif
                    <input type="file" name="image" class="form-control-file">
                </div>
            </div>

            <button class="btn btn-primary mt-3">Update Store</button>
            <a href="{{ route('store_location.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
@endsection

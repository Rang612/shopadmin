@extends('admin.layout.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create New Store</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route ('store_location.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    <div class="container">
        <form action="{{ route('store_location.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Store Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group col-md-6">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" required>
                </div>

                <div class="form-group col-md-6">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label>Opening Time</label>
                    <input type="time" name="opening_time" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Closing Time</label>
                    <input type="time" name="closing_time" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label>Latitude</label>
                    <input type="text" id="latitude" name="latitude" class="form-control" required>
                </div>

                <div class="form-group col-md-3">
                    <label>Longitude</label>
                    <input type="text" id="longitude" name="longitude" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <a href="#" id="preview-map" target="_blank" class="btn btn-outline-secondary btn-sm">
                    See on map
                </a>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Featured</label>
                    <select name="is_featured" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>Image (optional)</label>
                    <input type="file" name="image" class="form-control-file mt-1">
                </div>
            </div>

            <button class="btn btn-primary mt-3">Save Store</button>
        </form>
    </div>
@endsection

@section('customJs')
    <script>
        function updateMapPreviewLink() {
            const lat = document.getElementById('latitude').value;
            const lng = document.getElementById('longitude').value;

            if (lat && lng) {
                document.getElementById('preview-map').href = `https://www.google.com/maps?q=${lat},${lng}`;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('latitude').addEventListener('input', updateMapPreviewLink);
            document.getElementById('longitude').addEventListener('input', updateMapPreviewLink);
        });
    </script>
@endsection

@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route ('products.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" method="post" name="productForm" id="productForm">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Slug</label>
                                        <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br>Drop files here or click to upload.<br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="product-gallery">

                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="compare_price">Compare at Price</label>
                                        <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                        <p class="text-muted mt-3">
                                            To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventory</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="hidden" name="track_qty" value="No">
                                            <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" checked>
                                            <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty" readonly>
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4  mb-3">Product category</h2>
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                    @if($categories->isNotEmpty())
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="mb-3">
                                <label for="category">Sub category</label>
                                <select name="sub_category" id="sub_category" class="form-control">
                                    <option value="">Select a Sub Category</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product brand</h2>
                            <div class="mb-3">
                                <select name="brand" id="brand" class="form-control">
                                    <option value="">Select a Brand</option>
                                    @if($brands->isNotEmpty())
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Featured product</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Tags</h2>
                            <div class="mb-3">
                                <select multiple class="tag-products w-100" name="tags[]" id="tag-products"></select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product Variants</h2>
                            <div id="variant-wrapper">
                                <div class="row mb-2 variant-row">
                                    <div class="col-md-4">
                                        <input type="text" name="variants[0][color]" class="form-control" placeholder="Color">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="variants[0][size]" class="form-control" placeholder="Size">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="variants[0][qty]" class="form-control" placeholder="Qty">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-variant">X</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-variant" class="btn btn-outline-primary mt-3">+ Add Variant</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route ('products.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
        </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
@section('customJs')
    <script>
        $('.tag-products').select2({
            tags: true,
            tokenSeparators: [','],
            ajax: {
                url: '{{ route('products.getTags') }}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    console.log('Dữ liệu từ API:', data); // ✅ Kiểm tra dữ liệu API trả về

                    let uniqueTags = [];
                    let seen = new Set();

                    data.tags.forEach(tag => {
                        if (!seen.has(tag.id)) {
                            uniqueTags.push({ id: tag.id, text: tag.name });
                            seen.add(tag.id);
                        }
                    });

                    return { results: uniqueTags }; // ✅ Đảm bảo không có tag trùng lặp
                }
            }
        });




        $("#title").change(function() {
            element = $(this);
            $("button[type='submit']").prop('disabled', true);

            $.ajax({
                url: '{{ route("getSlug") }}',
                type: 'get',
                data: {title: element.val()},
                dataType: 'json',
                success: function (response) {
                    $("button[type='submit']").prop('disabled', false);

                    if(response["status"]===true){
                        $("#slug").val(response["slug"]);
                    }
                }
            });
        });

        $("#productForm").submit(function (event){
            event.preventDefault();
            var formArray = $(this).serializeArray();
            $("button[type='submit']").prop('disabled', true);
            $.ajax({
                url: '{{route("products.store")}}',
                type: 'post',
                data: formArray,
                dataType: 'json',
                success: function (response) {
                    $("button[type='submit']").prop('disabled', false);
                    if(response["status"]===true){
                        $(".error").removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='number']").removeClass('is-invalid');


                        window.location.href = '{{route("products.index")}}';
                    } else{
                        var errors = response["error"];
                        $(".error").removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='number']").removeClass('is-invalid');
                        $.each(errors, function (key, value){
                            $(`#${key}`).add('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(value);
                        })

                    }
                },
                error: function (response) {
                    $("button[type='submit']").prop('disabled', false);
                }
            });
        });

        $("#category").change(function (){
            var category_id = $(this).val();
            $.ajax({
                url: '{{ route("product-subcategories.index") }}',
                type: 'get',
                data: {category_id: category_id},
                dataType: 'json',
                success: function (response) {
                    $("#sub_category").find('option').not(":first").remove();
                    $.each(response["subCategories"], function (key, item) {
                        $("#sub_category").append(`<option value='${item.id}'>${item.name}</option>`);
                    });
                },
                error: function () {
                    console.log("Error");
                }
            });
        });

        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url: "{{ route('temp-images.create') }}",
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg, image/png, image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function (file, response){
                // $("#image_id").val(response.image_id);
               var html = `<div class = "col-md-3" id="image-row-${response.image_id}"><div class="card" >
                   <input type="hidden" name="image_array[]" value="${response.image_id}">
                    <img src="${response.ImagePath}" class="card-img-top" alt="">
                        <div class="card-body">
                           <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Delete</a>
                        </div>
                </div></div>`;
                $("#product-gallery").append(html);
            },

            complete: function (file){
                    this.removeFile(file);
            }
        });

        function deleteImage(id){
            $("#image-row-"+id).remove();
        }

        let variantIndex = 1;

        $("#add-variant").click(function () {
            $("#variant-wrapper").append(`
        <div class="row mb-2 variant-row">
            <div class="col-md-4">
                <input type="text" name="variants[${variantIndex}][color]" class="form-control" placeholder="Color">
            </div>
            <div class="col-md-4">
                <input type="text" name="variants[${variantIndex}][size]" class="form-control" placeholder="Size">
            </div>
            <div class="col-md-3">
                <input type="number" name="variants[${variantIndex}][qty]" class="form-control" placeholder="Qty">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-variant">X</button>
            </div>
        </div>
    `);
            variantIndex++;
        });

        $(document).on('click', '.remove-variant', function () {
            $(this).closest('.variant-row').remove();
            calculateTotalQty();
        });

        function calculateTotalQty() {
            let total = 0;
            $('input[name^="variants"]').each(function () {
                if ($(this).attr('name').includes('[qty]')) {
                    let val = parseInt($(this).val()) || 0;
                    total += val;
                }
            });
            $('#qty').val(total);
        }

        $(document).on('input', 'input[name^="variants"]', function () {
            calculateTotalQty();
        });

    </script>
@endsection

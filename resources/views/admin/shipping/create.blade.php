@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shipping Management</h1>
                </div>
{{--                <div class="col-sm-6 text-right">--}}
{{--                    <a href="{{route('shipping.create')}}" class="btn btn-primary">Back</a>--}}
{{--                </div>--}}
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('admin.message')
            <form action="{{route('shipping.store')}}" method="post" id="shippingForm" name="shippingForm">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <select name="country" id="country" class="form-control">
                                        <option value="">Select a country</option>
                                        @if($countries->isNotEmpty())
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="text" name="shipping_cost" id="shipping_cost" class="form-control" placeholder="Shipping Cost" >
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Shipping Cost</th>
                                    <th>Action</th>
                                </tr>
                                @if($shippingCharges->isNotEmpty())
                                    @foreach($shippingCharges as $shippingCharge)
                                        <tr>
                                            <td>{{$shippingCharge->id}}</td>
                                            <td>{{$shippingCharge->country_name}}</td>
                                            <td>{{$shippingCharge->shipping_cost}}</td>
                                            <td>
                                                <a href="{{route('shipping.edit',$shippingCharge->id )}}" class="btn btn-primary">Edit</a>
                                                <a href="javascript:void(0);" onclick="deleteShipping({{$shippingCharge->id}})" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>

        $("#shippingForm").submit(function (event){
            event.preventDefault();
            var element = $(this);
            $("button[type='submit']").prop('disabled', true);
            $.ajax({
                url: '{{ route("shipping.store") }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function (response){
                    $("button[type='submit']").prop('disabled', false);

                    if(response["status"] === true){
                        window.location.href = '{{ route("shipping.create") }}';
                    } else {
                        var errors = response['errors'];
                        if (errors['country']) {
                            $("#country").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['country']);
                        } else {
                            $("#country").removeClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html("");
                        }

                        if (errors['shipping_cost']) {
                            $("#shipping_cost").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['shipping_cost']);
                        } else {
                            $("#shipping_cost").removeClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html("");
                        }
                    }
                }, error: function (jqXHR, exception){
                    console.log(jqXHR.responseText);
                }

            })
        })

        function deleteShipping(id){
            var url = '{{ route("shipping.delete", "ID") }}';
            var newUrl = url.replace("ID", id);
            if (confirm("Are you sure you want to delete")) {
                $.ajax({
                    url: newUrl,
                    type: 'DELETE',
                    data: {},
                    dataType: 'json',
                    success: function (response) {
                        if (response["status"] === true) {
                            window.location.href = "{{ route('shipping.create') }}";
                        } else{
                            window.location.href = "{{ route('shipping.create') }}";
                        }
                    },
                });
            }
        }
    </script>
@endsection

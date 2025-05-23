@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shipping Edit</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('shipping.create')}}" class="btn btn-primary">Back</a>
                </div>
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
                                                <option {{($shippingCharge->country_id == $country->id ? 'selected' : '')}} value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input value="{{$shippingCharge->shipping_cost}}" type="text" name="shipping_cost" id="shipping_cost" class="form-control" placeholder="Shipping Cost" >
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
                url: '{{ route("shipping.update", $shippingCharge->id) }}',
                type: 'put',
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
    </script>
@endsection

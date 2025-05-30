@extends('admin.layout.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Order: #{{$order->id}}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('orders.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                @include('admin.message')
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <h1 class="h5 mb-3">Shipping Address</h1>
                                <address>
                                    <strong>{{$order->first_name.' '.$order->last_name}}</strong><br>
                                   {{$order->house_number}}, {{$order->street}}<br>
                                    {{$order->ward}}, {{$order->district}}, {{$order->country_name}}<br>
                                    Phone: {{$order->mobile}}<br>
                                    Email: {{$order->email}}
                                </address>
                                <strong>Shipped Data:</strong>
                                @if(!empty($order->shipped_date))
                                    {{\Carbon\Carbon::parse($order->shipped_date)->format('d M, Y')}}
                                    @else
                                    n/a
                                @endif
                            </div>
                            <div class="col-sm-4 invoice-col">
{{--                                <b>Invoice #007612</b><br>--}}
{{--                                <br>--}}
                                <b>Order ID:</b>{{$order->id}}<br>
                                <b>Total:</b> {{ number_format($order->grand_total, 0, ',', '.') }}VND<br>
                                <b>Status:</b>
                                @if($order->status == 'pending')
                                    <span class="text-warning">Pending</span>
                                @elseif($order->status == 'processing')
                                    <span class="text-info">Processing</span>
                                @elseif($order->status == 'completed')
                                    <span class="text-success">Completed</span>
                                @elseif($order->status == 'decline')
                                    <span class="text-danger">Declined</span>
                                @endif
                                <br>
                                <b>Payment Status:</b>
                                @if($order->payment_status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($order->payment_status == 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @elseif($order->payment_status == 'cod')
                                    <span class="badge bg-info">COD</span>
                                @elseif($order->payment_status == 'unpaid')
                                    <span class="badge bg-danger">Unpaid</span>
                                @endif
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-3">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th width="100">Price</th>
                                <th width="100">Qty</th>
                                <th width="100">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orderItems as $item)
                                <tr>
                                    <td>{{$item-> name}} ({{$item->color}} , {{$item->size}} )</td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }}VND</td>
                                    <td>{{$item->qty}}</td>
                                    <td>{{ number_format($item->total, 0, ',', '.') }}VND</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="3" class="text-right">Subtotal:</th>
                                <td>{{ number_format($order->subtotal, 0, ',', '.') }}VND</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-right">Discount:{{(!empty($order->coupon_code)) ? '('. $order->coupon_code.')' : ''}}</th>
                                <td>{{ number_format($order->discount, 0, ',', '.') }}VND</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-right">Shipping:</th>
                                <td>{{ number_format($order->shipping, 0, ',', '.') }}VND</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-right">Grand Total:</th>
                                <td>{{ number_format($order->grand_total, 0, ',', '.') }}VND</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <form action="" method="post" name="changeOrderStatusForm" id="changeOrderStatusForm">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Order Status</h2>
                        <div class="mb-3">
                            <select name="status" id="status" class="form-control">
                                <option value="pending" {{($order->status =='pending') ? 'selected' : ''}}>Pending</option>
                                <option value="processing" {{($order->status =='processing') ? 'selected' : ''}}>Processing</option>
                                <option value="completed" {{($order->status =='completed') ? 'selected' : ''}}>Completed</option>
                                <option value="decline" {{($order->status =='decline') ? 'selected' : ''}}>Declined</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="shipped_date" class="form-label">Shipped Date</label>
                            <input value="{{$order->shipped_date}}" type="text" name="shipped_date" id="shipped_date" class="form-control" placeholder="Shipped Date">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </div>
                    </form>
                </div>
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <form action="" method="post" name="sendInvoiceEmailForm" id="sendInvoiceEmailForm">--}}
{{--                        <h2 class="h4 mb-3">Send Inovice Email</h2>--}}
{{--                        <div class="mb-3">--}}
{{--                            <select name="status" id="status" class="form-control">--}}
{{--                                <option value="">Customer</option>--}}
{{--                                <option value="">Admin</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <button type="submit" class="btn btn-primary">Send</button>--}}
{{--                        </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
    <script>
        $(document).ready(function(){
            $('#shipped_date').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
        });

        $("#changeOrderStatusForm").submit(function (event){
            event.preventDefault();

            $.ajax({
                url: '{{route('orders.changeOrderStatus', $order->id)}}',
                type: 'POST',
                data: $(this).serializeArray(),
                success: function(response){
                    window.location.href='{{ route("orders.detail", $order->id)}}';                }
            })
        })
        {{--$("#sendInvoiceEmailForm").submit(function (event){--}}
        {{--    event.preventDefault();--}}

        {{--    $.ajax({--}}
        {{--        url: '{{route('orders.sendInvoiceEmail', $order->id)}}',--}}
        {{--        type: 'POST',--}}
        {{--        data: $(this).serializeArray(),--}}
        {{--        success: function(response){--}}
        {{--            window.location.href='{{ route("orders.detail", $order->id)}}';                }--}}
        {{--    })--}}
        {{--})--}}

    </script>
@endsection

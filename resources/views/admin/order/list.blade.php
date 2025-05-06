@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                </div>
                <div class="col-sm-6 text-right">
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
            <div class="card">
                <form action="" method="get">
                    <div class="card-header">
                        <div class="card-title">
                            <button type="button" onclick="window.location.href='{{route("orders.index")}}'"
                                    class="btn btn-default btn-sm ">All
                            </button>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input value="{{Request::get('keyword')}}" type="text" name="keyword"
                                       class="form-control float-right" placeholder="Search">
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
                            <th width="60">Order#</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Date Purchased</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($orders->isNotEmpty())
                            @foreach($orders as $order)
                                <tr onclick="window.location='{{ route('orders.detail', [$order->id]) }}'" style="cursor: pointer;">
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->name}}</td>
                                    <td>{{$order->email}}</td>
                                    <td>{{$order->mobile}}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge badge-info">Processing</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($order->status == 'decline')
                                            <span class="badge badge-danger">Declined</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($order->grand_total, 0, ',', '.') }}VND</td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No data found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{$orders->links()}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>

    </script>
@endsection

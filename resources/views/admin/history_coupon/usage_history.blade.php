@extends('admin.layout.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Coupon code usage history</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            @include('admin.message')
            <div class="card">
                <form action="" method="get">
                    <div class="card-header">
                        <div class="row w-100">
                            <div class="card-title">
                                <button type="button" onclick="window.location.href='{{route('admin.coupons.usage')}}'"
                                        class="btn btn-default btn-sm ">All
                                </button>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="keyword" class="form-control" placeholder="Name, email, coupon code, order ID"
                                       value="{{ request()->get('keyword') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="from_date" class="form-control" value="{{ request()->get('from_date') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="to_date" class="form-control" value="{{ request()->get('to_date') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">Filter</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Coupon Code</th>
                            <th>Type</th>
                            <th>Discount</th>
                            <th>Used Value</th>
                            <th>Order#</th>
                            <th>Used At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($orders->isNotEmpty())
                            @foreach ($orders as $order)
                                <tr onclick="window.location='{{ route('orders.detail', $order->id) }}'" style="cursor: pointer;">
                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                    <td>{{ $order->user->email ?? '-' }}</td>
                                    <td>{{ $order->coupon->code ?? '-' }}</td>
                                    <td>{{ $order->coupon->type === 'percent' ? 'Percent' : 'Fix Price' }}</td>
                                    <td>
                                        {{ $order->coupon->type === 'percent'
                                            ? $order->coupon->discount_amount . '%'
                                            : number_format($order->coupon->discount_amount, 0, ',', '.') . ' VND' }}
                                    </td>
                                    <td>{{ number_format($order->discount ?? 0, 0, ',', '.') }} VND</td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">No history of using coupon codes.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection


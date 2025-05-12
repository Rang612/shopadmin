<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::latest('orders.created_at')->select('orders.*','users.name','users.email');
        $orders = $orders->leftJoin('users','users.id','orders.user_id');
        if($request->get('keyword') != null){
            $orders = $orders->where('users.name','like','%'.$request->get('keyword').'%');
            $orders = $orders->orwhere('users.email','like','%'.$request->get('keyword').'%');
            $orders = $orders->orwhere('orders.id','like','%'.$request->get('keyword').'%');
        }
        $orders = $orders->paginate(10);
        return view('admin.order.list',[
            'orders' => $orders
        ]);
    }

    public function detail($orderId)
    {
        $order = Order::select('orders.*','countries.name as country_name')
                    ->where('orders.id',$orderId)
                    ->leftJoin('countries','countries.id','orders.country_id')
                    ->first();
        $orderItems = OrderItem::where('order_id',$orderId)->get();
        return view('admin.order.detail',[
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }

    public function changeOrderStatus(Request $request, $orderId)
    {
        $order = Order::with('orderDetail')->findOrFail($orderId);

        foreach ($order->orderDetail as $item) {
            // Tìm biến thể
            $productDetail = ProductDetail::where('product_id', $item->product_id)
                ->where('color', $item->color)
                ->where('size', $item->size)
                ->first();

            // Trừ kho khi sang processing
            if ($request->status === 'processing' && $order->status !== 'processing') {
                if ($productDetail && $productDetail->qty >= $item->qty) {
                    $productDetail->decrement('qty', $item->qty);

                    // Trừ tồn kho tổng
                    $product = $productDetail->product;
                    if ($product && $product->track_qty === 'Yes') {
                        $product->decrement('qty', $item->qty);
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'Not enough stock']);
                }
            }

            // Cộng lại kho nếu đơn bị huỷ sau khi đã trừ
            if ($request->status === 'decline' && $order->status === 'processing') {
                if ($productDetail) {
                    $productDetail->increment('qty', $item->qty);

                    // Cộng tồn kho tổng
                    $product = $productDetail->product;
                    if ($product && $product->track_qty === 'Yes') {
                        $product->increment('qty', $item->qty);
                    }
                }
            }
        }
        // Cập nhật đơn hàng
        $order->status = $request->status;
        $order->shipped_date = $request->shipped_date;
        $order->save();

        return response()->json([
            'status' => true,
            'message' => 'Order status updated successfully'
        ]);
    }

}

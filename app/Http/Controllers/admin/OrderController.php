<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::latest('order.created_at')->select('order.*','users.name','users.email');
        $orders = $orders->leftJoin('users','users.id','order.user_id');
        if($request->get('keyword') != null){
            $orders = $orders->where('users.name','like','%'.$request->get('keyword').'%');
            $orders = $orders->orwhere('users.email','like','%'.$request->get('keyword').'%');
            $orders = $orders->orwhere('order.id','like','%'.$request->get('keyword').'%');
        }
        $orders = $orders->paginate(10);
        return view('admin.order.list',[
            'orders' => $orders
        ]);
    }

    public function detail($orderId)
    {
        $order = Order::select('order.*','countries.name as country_name')
                    ->where('order.id',$orderId)
                    ->leftJoin('countries','countries.id','order.country_id')
                    ->first();
        $orderItems = OrderItem::where('order_id',$orderId)->get();
        return view('admin.order.detail',[
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }

    public function changeOrderStatus(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        $order->status = $request->status;
        $order->shipped_date = $request->shipped_date;
        $order->save();
        session()->flash('success','Order status updated successfully');
        return response()->json([
            'status' => true,
            'message' => 'Order status updated successfully'
        ]);
    }

//    public function sendInvoiceEmail(Request $request, $orderId)
//    {
//        orderEmail($orderId);
//    }


}

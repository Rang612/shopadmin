<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class DiscountCodeController extends Controller
{
    public function index(Request $request)
    {
        $discountCoupons = DiscountCoupon::latest();

        if(!empty($request->get('keyword'))){
            $discountCoupons = $discountCoupons->where('name', 'like', '%'.$request->get('keyword').'%');
            $discountCoupons = $discountCoupons->orwhere('code', 'like', '%'.$request->get('keyword').'%');

        }
        $discountCoupons = $discountCoupons->paginate(10);
        return view('admin.coupon.list', compact('discountCoupons'));
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            if (!empty($request->starts_at)) {
                $now = Carbon::now();
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);
                if ($startAt->lte($now)) {
                    $errors['starts_at'] = ['Start date must be greater than today'];
                }
            }

            if (!empty($request->starts_at) && !empty($request->expires_at)) {
                $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);
                if ($expiresAt->lte($startAt)) {
                    $errors['expires_at'] = ['End date must be greater than start date'];
                }
            }

            if (!empty($errors)) {
                return response()->json([
                    'status' => false,
                    'errors' => $errors
                ]);
            }

            $discountCode = new DiscountCoupon();
            $discountCode->code = $request->code;
            $discountCode->name = $request->name;
            $discountCode->description = $request->description;
            $discountCode->max_uses = $request->max_uses;
            $discountCode->max_uses_user = $request->max_uses_user;
            $discountCode->type = $request->type;
            $discountCode->discount_amount = $request->discount_amount;
            $discountCode->min_amount = $request->min_amount;
            $discountCode->status = $request->status;
            $discountCode->starts_at = $request->starts_at;
            $discountCode->expires_at = $request->expires_at;
            $discountCode->save();

            session()->flash('success', 'Discount code created successfully');
            return response()->json([
                'status' => true,
                'message' => 'Discount code created successfully'
            ]);

        } else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $coupon = DiscountCoupon::find($id);
        if(empty($coupon)){
            session()->flash('error', 'Discount code not found');
            return redirect()->route('coupons.index');
        }
        $data['coupon'] = $coupon;
        return view('admin.coupon.edit', $data);

    }

    public function update(Request $request, $id)
    {

        $discountCode = DiscountCoupon::find($id);
        if(empty($discountCode)){
            session()->flash('error', 'Discount code not found');
            return response()->json([
                'status' => true
            ]);
        }
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required',
        ]);

        if ($validator->passes()) {

            if (!empty($request->starts_at) && !empty($request->expires_at)) {
                $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->starts_at);
                if ($expiresAt->lte($startAt)) {
                    $errors['expires_at'] = ['End date must be greater than start date'];
                }
            }
            if (!empty($errors)) {
                return response()->json([
                    'status' => false,
                    'errors' => $errors
                ]);
            }
            $discountCode->code = $request->code;
            $discountCode->name = $request->name;
            $discountCode->description = $request->description;
            $discountCode->max_uses = $request->max_uses;
            $discountCode->max_uses_user = $request->max_uses_user;
            $discountCode->type = $request->type;
            $discountCode->discount_amount = $request->discount_amount;
            $discountCode->min_amount = $request->min_amount;
            $discountCode->status = $request->status;
            $discountCode->starts_at = $request->starts_at;
            $discountCode->expires_at = $request->expires_at;
            $discountCode->save();

            session()->flash('success', 'Discount code updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'Discount code created successfully'
            ]);

        } else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $discountCode = DiscountCoupon::find($id);
        if($discountCode == null){
            session()->flash('error', 'Discount code not found');
            return response()->json([
                'status' => true,
            ]);
        }
        $discountCode->delete();
        session()->flash('success', 'Discount code deleted successfully');
        return response()->json([
            'status' => true,
        ]);
    }

    public function couponUsageHistory(Request $request)
    {
        $orders = Order::query()
            ->select('orders.*')
            ->with(['user', 'coupon'])
            ->whereNotNull('coupon_code_id')
            ->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->leftJoin('discount_coupons', 'discount_coupons.id', '=', 'orders.coupon_code_id');

        // Tìm kiếm keyword
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $orders->where(function ($query) use ($keyword) {
                $query->where('users.name', 'like', "%{$keyword}%")
                    ->orWhere('users.email', 'like', "%{$keyword}%")
                    ->orWhere('orders.id', 'like', "%{$keyword}%")
                    ->orWhere('discount_coupons.code', 'like', "%{$keyword}%");
            });
        }
        // Lọc theo khoảng ngày
        if ($request->filled('from_date')) {
            $orders->whereDate('orders.created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $orders->whereDate('orders.created_at', '<=', $request->to_date);
        }
        $orders = $orders->orderByDesc('orders.created_at')
            ->paginate(20)
            ->withQueryString();
        return view('admin.history_coupon.usage_history', compact('orders'));
    }


}

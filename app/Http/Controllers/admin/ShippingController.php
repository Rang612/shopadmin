<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
     public function create(){
         $countries = Country::get();
         $data['countries'] = $countries;
         $shippingCharges = ShippingCharge::select('shipping_charges.*', 'countries.name as country_name')
             ->leftJoin('countries', 'shipping_charges.country_id', '=', 'countries.id')
             ->get();
         $data['shippingCharges'] = $shippingCharges;

         return view('admin.shipping.create', $data);
     }

        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'country' => 'required',
                'shipping_cost' => 'required|numeric'
            ]);

            if($validator->passes())
            {
                $count = ShippingCharge::where('country_id', $request->country)->count();
                if ($count > 0) {
                    session()->flash('error', 'Shipping cost already added for this country');
                    return response()->json([
                        'status' => true,
                    ]);
                }
                $shipping = new ShippingCharge();
                $shipping->country_id = $request->country;
                $shipping->shipping_cost = $request->shipping_cost;
                $shipping->save();

                session()->flash('success', 'Shipping cost added successfully');
                return response()->json([
                    'status' => true,
                    ]);

            } else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }
        }

        public function edit($id)
        {
            $shippingCharge = ShippingCharge::find($id);
            $countries = Country::get();
            $data['countries'] = $countries;
            $data['shippingCharge'] = $shippingCharge;
            return view('admin.shipping.edit', $data);
        }

    public function update($id, Request $request)
    {
        $shipping = ShippingCharge::find($id);
        $validator = Validator::make($request->all(), [
            'country' => 'required',
            'shipping_cost' => 'required|numeric'
        ]);

        if($validator->passes())
        {
            if($shipping == null){
                session()->flash('error', 'Shipping cost not found');
                return response()->json([
                    'status' => true,
                ]);
            }
            $shipping->country_id = $request->country;
            $shipping->shipping_cost = $request->shipping_cost;
            $shipping->save();

            session()->flash('success', 'Shipping cost updated successfully');
            return response()->json([
                'status' => true,
            ]);

        } else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id)
    {
        $shippingCharge = ShippingCharge::find($id);
        if($shippingCharge == null){
            session()->flash('error', 'Shipping cost not found');
            return response()->json([
                'status' => true,
            ]);
        }
        $shippingCharge->delete();
        session()->flash('success', 'Shipping cost deleted successfully');
        return response()->json([
            'status' => true,
        ]);

    }

}

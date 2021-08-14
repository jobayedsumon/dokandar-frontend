<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    //
    public function my_account()
    {
        $user_id = auth()->id();
        $ongoing = DB::table('orders')
            ->leftJoin('delivery_boy', 'orders.dboy_id', '=', 'delivery_boy.delivery_boy_id')
            ->join('vendor','orders.vendor_id','=','vendor.vendor_id')
            ->join('user_address','orders.address_id','=','user_address.address_id')
            ->where('orders.user_id',$user_id)
            ->where('orders.payment_method', '!=', NULL)
            ->orderBy('orders.order_id', 'DESC')
            ->get();

        if(count($ongoing)>0){
            foreach($ongoing as $ongoings){
                $order = DB::table('order_details')
                    ->leftJoin('product_varient', 'order_details.varient_id','=','product_varient.varient_id')
                    ->select('order_details.*','product_varient.description')
                    ->where('order_details.order_cart_id',$ongoings->cart_id)
                    ->orderBy('order_details.order_date', 'DESC')
                    ->get();


                $data[]=array('order_status'=>$ongoings->order_status,'vendor_name'=>$ongoings->vendor_name, 'delivery_date'=>$ongoings->delivery_date, 'time_slot'=>$ongoings->time_slot,'payment_method'=>$ongoings->payment_method,'payment_status'=>$ongoings->payment_status,'paid_by_wallet'=>$ongoings->paid_by_wallet, 'cart_id'=>$ongoings->cart_id ,'price'=>$ongoings->total_price,'delivery_charge'=>$ongoings->delivery_charge,'remaining_amount'=>$ongoings->rem_price,'coupon_discount'=>$ongoings->coupon_discount,'delivery_boy_name'=>$ongoings->delivery_boy_name,'delivery_boy_phone'=>$ongoings->delivery_boy_phone,
                    'address'=>$ongoings->address,'data'=>$order);
            }
        }
        else{
            $data=array('data'=>[]);
        }

        $response = Http::post(baseUrl('show_address'), [
            'user_id' => auth()->id()
        ]);
        $address_list = $response->ok() ? $response->json('data') : [];

        return view('my-account', compact('data', 'address_list'));
    }

    public function add_address(Request $request)
    {
        $data = $request->except('_token');
        $data['user_id'] = auth()->id();
        $data['user_name'] = auth()->user()->user_name;
        $data['user_number'] = auth()->user()->user_phone;

        $response = Http::post(baseUrl('add_address'), $data);
        return $response->ok() ? redirect()->back()->with('msg', 'Address added successfully') : redirect()->back()->with('msg', 'Address couldn\'t be added');
    }

    public function delete_address($id)
    {
        $response = Http::post(baseUrl('remove_address'), [
            'address_id' => $id
        ]);
        return $response->ok() ? redirect()->back()->with('msg', $response->json('message')) : redirect()->back()->with('msg', 'Address couldn\'t be deleted');
    }

    public function order_details($cart_id)
    {
        $ongoing = DB::table('orders')
            ->leftJoin('delivery_boy', 'orders.dboy_id', '=', 'delivery_boy.delivery_boy_id')
            ->join('vendor','orders.vendor_id','=','vendor.vendor_id')
            ->join('user_address','orders.address_id','=','user_address.address_id')
            ->where('orders.cart_id',$cart_id)
            ->first();


        if($ongoing){

            if ($ongoing->ui_type == 1) {
                $order = DB::table('order_details')
                    ->leftJoin('product_varient', 'order_details.varient_id','=','product_varient.varient_id')
                    ->select('order_details.*','product_varient.*')
                    ->where('order_details.order_cart_id',$ongoing->cart_id)
                    ->orderBy('order_details.order_date', 'DESC')
                    ->get();
            } else {

                $order = DB::table('order_details')
                    ->leftjoin('resturant_variant', 'order_details.varient_id', '=', 'resturant_variant.variant_id')
                    ->select('order_details.*', 'resturant_variant.*')
                    ->where('order_details.order_cart_id',$ongoing->cart_id)
                    ->orderBy('order_details.order_date', 'DESC')
                    ->get();
            }


            $data=array('order_status'=>$ongoing->order_status,'vendor_name'=>$ongoing->vendor_name, 'order_date'=>$ongoing->order_date, 'delivery_date'=>$ongoing->delivery_date, 'time_slot'=>$ongoing->time_slot,'payment_method'=>$ongoing->payment_method,'payment_status'=>$ongoing->payment_status,'paid_by_wallet'=>$ongoing->paid_by_wallet, 'cart_id'=>$ongoing->cart_id ,'price'=>$ongoing->total_price,'delivery_charge'=>$ongoing->delivery_charge,'remaining_amount'=>$ongoing->rem_price,'coupon_discount'=>$ongoing->coupon_discount,'delivery_boy_name'=>$ongoing->delivery_boy_name,'delivery_boy_phone'=>$ongoing->delivery_boy_phone,
                'address'=>$ongoing->address,'details'=>$order);
        }
        else {
            $data = [];
        }

            //dd($data);

        return view('order-details', compact('data'));
    }
}

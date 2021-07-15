<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->where('orders.ui_type', '1')
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

        return view('my-account', compact('data'));
    }
}

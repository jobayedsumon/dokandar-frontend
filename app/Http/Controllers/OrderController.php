<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    //
    public function apply_coupon(Request $request, $cart_id)
    {
        $response = Http::post(baseUrl('apply_coupon'), [
            'cart_id' => $cart_id,
            'coupon_code' => $request->coupon_code,
        ]);

        $couponOrder = $response->ok() ? $response->json('data'): null;

        if ($couponOrder) {
            if ($couponOrder['coupon_discount']) {
                return redirect()->back()->with('coupon_code', $request->coupon_code);
            } else {
                return redirect()->back()->with('msg', 'Coupon is not valid');
            }
        }  else {
            return redirect()->back()->with('msg', 'Coupon is not valid');
        }

    }

    public function checkout()
    {
        $cartDetails = session()->get('cart') ?? [];
        $vendor_id = session()->get('vendor_id') ?? null;

        if ($vendor_id) {

            $vendor = DB::table('vendor')->select('ui_type')->where('vendor_id', $vendor_id)->first();
            $ui_type = $vendor->ui_type;

            if ($ui_type == 1) {
                foreach ($cartDetails as $i=>$c) {
                    $c['product'] = DB::table('product')->where('product_id', $c['product_id'])->first();
                    $c['variant'] = DB::table('product_varient')->where('varient_id', $c['variant_id'])->first();
                    $cartDetails[$i] = $c;
                }
            } elseif ($ui_type == 2 || $ui_type == 3) {
                foreach ($cartDetails as $i=>$c) {
                    $c['product'] = DB::table('resturant_product')->where('product_id', $c['product_id'])->first();
                    $c['variant'] = DB::table('resturant_variant')->where('variant_id', $c['variant_id'])->first();
                    if ($c['addons_id']) {
                        $c['addons'] = DB::table('restaurant_addons')->whereIn('addon_id', $c['addons_id'])->get();
                    } else {
                        $c['addons'] = [];
                    }

                    $cartDetails[$i] = $c;
                }
            } elseif ($ui_type == 4) {
                return redirect('/');
            }
        }

        $response = Http::post(baseUrl('show_address'), [
            'user_id' => auth()->id()
        ]);
        $address_list = $response->ok() ? $response->json('data') : [];

        $response = Http::post(baseUrl('city'), [
            'vendor_id' => $cartDetails[0]['product']->vendor_id
        ]);

        $city_list = $response->ok() ? $response->json('data') : [];

        $checkmap = DB::table('map_API')
            ->first();

        $minDate = date('Y-m-d');
        $maxDate = date('Y-m-d', strtotime($minDate.'+9 days'));

        return view('checkout', compact('cartDetails', 'address_list',
            'city_list', 'checkmap', 'minDate', 'maxDate', 'ui_type'));
    }

    public function order(Request $request)
    {

        $vendor_id = session()->get('vendor_id') ?? null;

        if ($vendor_id) {

            $vendor = DB::table('vendor')->select('ui_type')->where('vendor_id', $vendor_id)->first();
            $ui_type = $vendor->ui_type;

            $response = Http::post(baseUrl('select_address'), [
                'address_id' => $request->address_id
            ]);

            if ($response->ok()) {

                $cart = session()->get('cart');
                $data = [];
                $addons = [];

                if ($ui_type == 1) {
                    foreach ($cart as $c) {
                        array_push($data, [
                            'qty' => $c['qty'],
                            'varient_id' => $c['variant_id']
                        ]);
                    }

                    $response = Http::post(baseUrl('order'), [
                        'user_id' => auth()->id(),
                        'vendor_id' => session()->get('vendor_id'),
                        'delivery_date' => $request->delivery_date,
                        'time_slot' => $request->time_slot,
                        'order_array' => json_encode($data),
                        'ui_type' => $ui_type
                    ]);

                } elseif ($ui_type == 2 || $ui_type == 3) {
                    foreach ($cart as $c) {
                        array_push($data, [
                            'qty' => $c['qty'],
                            'variant_id' => $c['variant_id']
                        ]);
                        if ($c['addons_id']) {
                            foreach ($c['addons_id'] as $addon_id) {
                                array_push($addons, [
                                    'addon_id' => $addon_id
                                ]);
                            }
                        }

                    }

                    if ($ui_type == 2) {
                        $url = 'returant_order';
                    } elseif ($ui_type == 3) {
                        $url = 'pharmacy_order';
                    }

                    $response = Http::post(baseUrl($url), [
                        'user_id' => auth()->id(),
                        'vendor_id' => session()->get('vendor_id'),
                        'order_array' => json_encode($data),
                        'order_array1' => json_encode($addons),
                        'ui_type' => $ui_type
                    ]);

                } elseif ($ui_type == 4) {
                    return redirect('/');
                }

                $order = $response->ok() ? $response->json('data') : [];

                if ($order) {
                    return redirect(route('payment', $order['cart_id']));
                } else {
                    return redirect()->back()->with('msg', 'Order couldn\'t be placed');
                }

            } else {
                return redirect()->back()->with('msg', 'Address couldn\'t be selected');
            }
        }

    }

    public function payment_process(Request $request, $cart_id)
    {
        $response = Http::post(baseUrl('checkout'), [
            'cart_id' => $cart_id,
            'payment_method' => $request->payment_method
        ]);

        $order = $response->ok() ? $response->json('data') : [];

        if ($order) {
            session()->remove('cart');
            session()->remove('vendor_id');
            session()->remove('coupon_code');
            return redirect(route('order-feedback', $order['cart_id']));
        } else {
            redirect()->back()->with('msg', 'Payment couldn\'t be completed');
        }

    }

    public function payment($cart_id)
    {
        $order = DB::table('orders')->where('cart_id', $cart_id)->first();
        return view('payment', compact('order'));
    }

    public function order_feedback($cart_id)
    {
        $order = DB::table('orders')->where('cart_id', $cart_id)->first();
        return view('order-feedback', compact('order'));
    }
}

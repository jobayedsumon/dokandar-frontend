<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

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
                        'order_array1' => $addons ? json_encode($addons) : null,
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
        if ($request->payment_method == 'COD') {
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

        } else if($request->payment_method == 'ONLINE') {

            $orderData = DB::table('orders')->where('cart_id', $cart_id)->first();
            $customer = DB::table('tbl_user')->where('user_id', $orderData->user_id)->first();
            $address = DB::table('user_address')->where('address_id', $orderData->address_id)->first();

            $url = 'https://sandbox.aamarpay.com/request.php'; // live url https://secure.aamarpay.com/request.php
            $fields = array(
                'store_id' => env('STORE_ID'), //store id will be aamarpay,  contact integration@aamarpay.com for test/live id
                'amount' => $orderData->rem_price, //transaction amount
                'payment_type' => 'VISA', //no need to change
                'currency' => 'BDT',  //currenct will be USD/BDT
                'tran_id' => $orderData->cart_id, //transaction id must be unique from your end
                'cus_name' => $customer->user_name,  //customer name
                'cus_email' => $customer->user_email, //customer email address
                'cus_add1' => $address->address,  //customer address
                'cus_add2' => $address->street, //customer address
                'cus_city' => $address->state,  //customer city
                'cus_state' => $address->state,  //state
                'cus_postcode' => $address->pincode, //postcode or zipcode
                'cus_country' => 'Bangladesh',  //country
                'cus_phone' => $customer->user_phone, //customer phone number
                'cus_fax' => 'Not¬Applicable',  //fax
                'ship_name' => $customer->user_name, //ship name
                'ship_add1' => $address->address,  //ship address
                'ship_add2' => $address->street,
                'ship_city' => $address->state,
                'ship_state' => $address->state,
                'ship_postcode' => $address->pincode,
                'ship_country' => 'Bangladesh',
                'desc' => 'ORDER ID: '.$orderData->cart_id,
                'success_url' => route('success'), //your success route
                'fail_url' => route('fail'), //your fail route
                'cancel_url' => route('cancel'), //your cancel url
                'opt_a' => '',  //optional paramter
                'opt_b' => '',
                'opt_c' => '',
                'opt_d' => '',
                'signature_key' => env('SIGNATURE_KEY')); //signature key will provided aamarpay, contact integration@aamarpay.com for test/live signature key

            $fields_string = http_build_query($fields);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));
            curl_close($ch);

            $this->redirect_to_merchant($url_forward);
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

    function redirect_to_merchant($url) {

        ?>
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head><script type="text/javascript">
                function closethisasap() { document.forms["redirectpost"].submit(); }
            </script></head>
        <body onLoad="closethisasap();">

        <form name="redirectpost" method="post" action="<?php echo 'https://sandbox.aamarpay.com/'.$url; ?>"></form>
        <!-- for live url https://secure.aamarpay.com -->
        </body>
        </html>
        <?php
        exit;
    }


    public function success(Request $request){
        Session::save();
        $response = Http::post(baseUrl('checkout'), [
            'cart_id' => $request->mer_txnid,
            'payment_method' => $request->card_type,
            'payment_status' => 'success'
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

    public function fail(Request $request){
        redirect()->back()->with('msg', 'Payment couldn\'t be completed');
    }

    public function cancel(Request $request){
        redirect()->back()->with('msg', 'Payment was cancelled');
    }
}

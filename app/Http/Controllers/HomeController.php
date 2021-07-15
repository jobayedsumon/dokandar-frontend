<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{

    //
    public function homepage()
    {
        $response = Http::get(baseUrl('vendorcategory'));
        $vendorCategory = $response->ok() ? $response->json('data') : [];
        $data['vendorCategory'] = $vendorCategory;
        $response = Http::get(baseUrl('adminbanner'));
        $vendorCategory = $response->ok() ? $response->json('data') : [];
        $data['adminBanner'] = $vendorCategory;

        return view('homepage', compact('data'));
    }

    public function available_store($id, $ui_type)
    {
        $vendorCategory = DB::table('vendor_category')->where('vendor_category_id', $id)->first();

        $response = Http::post(baseUrl('nearbystore'), [
            'vendor_category_id' => $id,
            'ui_type' => $ui_type
        ]);
        $availableStore = $response->ok() ? $response->json('data') : [];
        $data['availableStore'] = $availableStore;
        $data['vendorCategory'] = $vendorCategory;

        return view('available_store', compact('data'));
    }

    public function categories($id)
    {
        if (session()->has('cart')) {
            return redirect()->back()->with('msg', 'Can not order from multiple vendor. Please clear previous cart to order.');
        } else {
            session()->put('vendor_id', $id);

            $response = Http::post(baseUrl('vendorbanner'), [
                'vendor_id' => $id
            ]);
            $vendorBanner = $response->ok() ? $response->json('data') : [];
            $data['vendorBanner'] = $vendorBanner;

            $response = Http::post(baseUrl('appcategory'), [
                'vendor_id' => $id
            ]);
            $categories = $response->ok() ? $response->json('data') : [];
            $data['categories'] = $categories;

            return view('categories', compact('data'));
        }

    }

    public function products($id)
    {

        $response = Http::post(baseUrl('appsubcategory'), [
            'category_id' => $id
        ]);
        $subCategories = $response->ok() ? $response->json('data') : [];
        foreach ($subCategories as $index => $subCategory) {
            $response = Http::post(baseUrl('appproduct'), [
                'subcat_id' => $subCategory['subcat_id']
            ]);
            $products = $response->ok() ? $response->json() : [];
            $subCategories[$index]['products'] = $products;
        }
        $data['subCategories'] = $subCategories;

        return view('products', compact('data'));
    }

    public function product_details($subId, $prodId)
    {
        $product = DB::table('product')->where('subcat_id', $subId)->where('product_id', $prodId)->first();
        $product_variant = DB::table('product_varient')->where('product_id', $prodId)->get();

        return view('product-details', compact('product', 'product_variant'));
    }

    public function product_action(Request $request, $id)
    {
        $cart = session()->get('cart');
        $cart[] = array(
            'cart_id' => uniqid(),
            'product_id' => $id,
            'variant_id' => $request->variant,
            'qty' => $request->qty,
        );
        session()->put('cart', $cart);

        if ($request->action == 1) {
            return redirect()->back()->with('msg', 'Product added to cart successfully');
        } elseif ($request->action == 2) {
            return redirect(route('checkout'));
        }
    }

    public function cart()
    {
        $cartDetails = session()->get('cart') ?? [];

        foreach ($cartDetails as $i=>$c) {
            $c['product'] = DB::table('product')->where('product_id', $c['product_id'])->first();
            $c['variant'] = DB::table('product_varient')->where('varient_id', $c['variant_id'])->first();
            $cartDetails[$i] = $c;
        }

        return view('cart', compact('cartDetails'));
    }

    public function remove_cart($id)
    {
        $cart = session()->get('cart');
        foreach ($cart as $i => $data) {
            if ($data['cart_id'] == $id) {
                unset($cart[$i]);
            }
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('msg', 'Item removed from cart');
    }

    public function checkout()
    {
        $cartDetails = session()->get('cart') ?? [];

        foreach ($cartDetails as $i=>$c) {
            $c['product'] = DB::table('product')->where('product_id', $c['product_id'])->first();
            $c['variant'] = DB::table('product_varient')->where('varient_id', $c['variant_id'])->first();
            $cartDetails[$i] = $c;
        }

        $response = Http::post(baseUrl('show_address'), [
            'user_id' => auth()->id()
        ]);
        $address_list = $response->ok() ? $response->json('data') : [];

        return view('checkout', compact('cartDetails', 'address_list'));
    }

    public function order(Request $request)
    {
        $cart = session()->get('cart');
        $data = [];

        foreach ($cart as $c) {
            array_push($data, [
                'qty' => $c['qty'],
                'varient_id' => $c['variant_id']
            ]);
        }

        $response = Http::post(baseUrl('order'), [
            'user_id' => auth()->id(),
            'vendor_id' => session()->get('vendor_id'),
            'order_array' => json_encode($data)
        ]);

        $order = $response->ok() ? $response->json('data') : [];

        return view('payment', compact('order'));

    }

    public function payment(Request $request)
    {
        $response = Http::post(baseUrl('checkout'), $request->except('_token'));

        $order = $response->ok() ? $response->json('data') : [];

        session()->remove('cart');
        session()->remove('vendor_id');

        return view('order-feedback', compact('order'));
    }
}

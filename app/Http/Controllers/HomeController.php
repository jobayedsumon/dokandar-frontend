<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

    public function available_store(Request $request, $vendor_cat_id, $ui_type)
    {
        $vendorCategory = DB::table('vendor_category')->where('vendor_category_id', $vendor_cat_id)->first();

        $data['availableStore'] = [];
        $data['vendorCategory'] = $vendorCategory;
        $data['vendor_category_id'] = $vendor_cat_id;
        $data['ui_type'] = $ui_type;

        return view('available_store', compact('data'));
    }

    public function vendor_type($vendor_id, $ui_type)
    {

        if ($ui_type == 1) {
            return redirect(route('grocery-categories', $vendor_id));
        } elseif ($ui_type == 2) {
            return redirect(route('restaurant-products', $vendor_id));
        } elseif ($ui_type == 3) {
            return redirect(route('pharmacy-products', $vendor_id));
        }


    }

    public function product_action(Request $request, $vendor_id, $prodId)
    {
        if (session()->has('vendor_id')) {
            if (session()->get('vendor_id') != $vendor_id) {
                return redirect()->back()->with('msg', 'Multiple vendors product can\'t be added to the cart.');
            }
        }
        $cart = session()->get('cart') ?? [];
        if (count($cart) >= 5) {
            return redirect()->back()->with('msg', 'Maximum 5 products can be ordered at a time.');
        }
        $cart[] = array(
            'cart_id' => uniqid(),
            'product_id' => $prodId,
            'variant_id' => $request->variant,
            'addons_id' => $request->addons,
            'qty' => $request->qty,
        );

        session()->put('cart', $cart);
        session()->put('vendor_id', $vendor_id);

        if ($request->action == 1) {
            return redirect()->back()->with('msg', 'Product added to cart successfully');
        } elseif ($request->action == 2) {
            return redirect(route('checkout'));
        }
    }

    public function cart()
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
        if (count($cart) <= 0) {
            session()->remove('vendor_id');
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('msg', 'Item removed from cart');
    }

}

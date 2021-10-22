<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RestaurantController extends Controller
{
    //
    public function products($vendor_id)
    {
        $response = Http::post(baseUrl('resturant_banner'), [
            'vendor_id' => $vendor_id
        ]);
        $restaurantBanner = $response->ok() ? $response->json('data') : [];
        $data['restaurantBanner'] = $restaurantBanner;

        $response = Http::post(baseUrl('homecategory'), [
            'vendor_id' => $vendor_id
        ]);

        $categories = $response->ok() ? $response->json('data') : [];


        $restaurantCats = [];

        foreach($categories as $key => $value){
            if (array_key_exists('resturant_cat_id', $value)) {
                $restaurantCats[$value['resturant_cat_id']][$key] = $value;
            }

        }

        $restaurantCats = array_values($restaurantCats);
        $data['restaurantCats'] = $restaurantCats;
        $data['vendor_id'] = $vendor_id;

        return view('restaurant.products', compact('data'));
    }

    public function product_details($vendor_id, $prodId)
    {
        $product = DB::table('resturant_product')->where('vendor_id', $vendor_id)->where('product_id', $prodId)->first();
        $product_variant = DB::table('resturant_variant')->where('product_id', $prodId)->get();
        $product_addons = DB::table('restaurant_addons')->where('product_id', $prodId)->get();

        return view('restaurant.product-details', compact('product', 'product_variant', 'product_addons'));
    }
}

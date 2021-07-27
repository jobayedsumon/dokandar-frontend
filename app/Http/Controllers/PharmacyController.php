<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PharmacyController extends Controller
{
    //
    public function products($vendor_id)
    {
        $response = Http::post(baseUrl('pharmacy_homecategory'), [
            'vendor_id' => $vendor_id
        ]);

        $categories = $response->ok() ? $response->json('data') : [];
        $pharmacyCats = [];

        foreach($categories as $key => $value){
            $pharmacyCats[$value['resturant_cat_id']][$key] = $value;
        }

        $pharmacyCats = array_values($pharmacyCats);
        $data['pharmacyCats'] = $pharmacyCats;
        $data['vendor_id'] = $vendor_id;

        //dd($data);

        return view('pharmacy.products', compact('data'));
    }

    public function product_details($vendor_id, $prodId)
    {
        $product = DB::table('resturant_product')->where('vendor_id', $vendor_id)->where('product_id', $prodId)->first();
        $product_variant = DB::table('resturant_variant')->where('product_id', $prodId)->get();
        $product_addons = DB::table('restaurant_addons')->where('product_id', $prodId)->get();

        return view('restaurant.product-details', compact('product', 'product_variant', 'product_addons'));
    }
}

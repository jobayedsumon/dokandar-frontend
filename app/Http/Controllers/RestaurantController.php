<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            $restaurantCats[$value['resturant_cat_id']][$key] = $value;
        }

        $restaurantCats = array_values($restaurantCats);
        $data['restaurantCats'] = $restaurantCats;

        return view('restaurant.products', compact('data'));
    }
}

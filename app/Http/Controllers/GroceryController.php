<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GroceryController extends Controller
{
    //

    public function categories($vendor_id)
    {
        $response = Http::post(baseUrl('vendorbanner'), [
            'vendor_id' => $vendor_id
        ]);
        $vendorBanner = $response->ok() ? $response->json('data') : [];
        $data['vendorBanner'] = $vendorBanner;

        $response = Http::post(baseUrl('appcategory'), [
            'vendor_id' => $vendor_id
        ]);
        $categories = $response->ok() ? $response->json('data') : [];
        $data['categories'] = $categories;

        return view('grocery.categories', compact('data'));
    }

    public function products($vendor_id, $cat_id)
    {
        $response = Http::post(baseUrl('vendorbanner'), [
            'vendor_id' => $vendor_id
        ]);
        $vendorBanner = $response->ok() ? $response->json('data') : [];
        $data['vendorBanner'] = $vendorBanner;

        $response = Http::post(baseUrl('appsubcategory'), [
            'category_id' => $cat_id
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

        return view('grocery.products', compact('data'));
    }
}

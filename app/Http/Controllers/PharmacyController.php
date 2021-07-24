<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        //dd($data);

        return view('pharmacy.products', compact('data'));
    }
}

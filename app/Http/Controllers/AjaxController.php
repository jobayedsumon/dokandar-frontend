<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AjaxController extends Controller
{
    //
    public function get_area_list(Request $request)
    {
        $response = Http::post(baseUrl('area'), $request->all());

        return $response->ok() ? $response->json('data') : [];
    }

    public function get_time_slots(Request $request)
    {
        $response = Http::post(baseUrl('timeslot'), $request->all());

        return $response->ok() ? $response->json('data') : [];
    }


    public function get_nearby_stores(Request $request)
    {
        $response = Http::post(baseUrl('nearbystore'), $request->all());
        return $response->ok() ? $response->json('data') : [];
    }
}

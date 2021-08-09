<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function register_form()
    {
        return view('register');
    }

    public function login_form()
    {
        return view('login');
    }

    public function register(Request $request)
    {
        if (strlen($request->user_phone) != 10) {
            return redirect()->back()->with('msg', 'Enter phone number correctly without country code');
        }
        $response = Http::post(baseUrl('user_register'), [
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_phone' => '+880'.$request->user_phone,
            'user_password' => 'no',
            'user_image' => 'user.png'
        ]);

        $user = $response->ok() ? $response->json('data') : [];
        if ($response->json('status') == 1) {
            return view('verification', ['user_id'=>$user['user_id']]);
        } else {
            return redirect()->back()->with('msg', $response->json('message'));
        }
    }

    public function login(Request $request)
    {
        if (strlen($request->user_phone) != 10) {
            return redirect()->back()->with('msg', 'Enter phone number correctly without country code');
        }

        $response = Http::post(baseUrl('checkuser'), [
            'user_phone' => '+880'.$request->user_phone,
        ]);
        $user = User::where('user_phone', '+880'.$request->user_phone)->first();

        if ($response->json('status') == 1) {
            return view('verification', ['user_id'=>$user->user_id]);
        } else {
            return redirect()->back()->with('msg', $response->json('message'));
        }
    }

    public function otp_verify(Request $request, $id)
    {
        $user = User::where('user_id', $id)->first();
        $response = Http::post(baseUrl('verify_phone'), [
            'phone' => $user->user_phone,
            'otp' => $request->otp
        ]);

        $user = $response->ok() ? $response->json('data') : [];
        if ($response->json('status') == 1) {
            Auth::loginUsingId($user['user_id']);
            return redirect('/');
        } else {
            return view('verification', ['user_id'=>$id, 'msg'=>$response->json('message')]);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->back();
    }
}

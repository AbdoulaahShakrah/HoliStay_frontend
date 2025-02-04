<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LogoutController extends Controller
{
    public function logout() {
        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;

        $response = Http::withToken($cleanToken)->post('http://127.0.0.1:8000/api/v1/logout');
        if($response->successful()){
            session()->forget('access_token');  
            return redirect('/home');
        }
        else{
            dd("logout falhou");
        }
    }
}

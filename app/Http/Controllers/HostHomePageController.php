<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HostHomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.host.host-homepage');
    }

    /**
     * Display a listing of the resource.
     */
    public function hostProperties($id)
    {
        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;

        $response = Http::withToken($cleanToken)->get("http://127.0.0.1:8000/api/v1/properties-by-host?host_id=".$id);
        $properties = $response->json()['data'];

        if( $id == session('host_id')){
            return view('pages.host.host-homepage', compact('properties'));
        }
        else{
            dd('Acesso negado!');
        }

        
    }
}

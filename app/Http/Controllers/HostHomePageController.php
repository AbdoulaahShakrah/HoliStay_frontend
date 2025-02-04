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
    public function hostProperties()
    {
        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;

        $response = Http::withToken($cleanToken)->get("http://127.0.0.1:8000/api/v1/properties-by-host?host_id=" . session('host_id'));
        $properties = $response->json()['data'];
        return view('pages.host.host-homepage', compact('properties'));
    }
}

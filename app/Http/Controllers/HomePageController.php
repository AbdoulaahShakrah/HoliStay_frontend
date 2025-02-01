<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class HomePageController extends Controller
{
    function index()
    {

        $categories_response = Http::get('http://127.0.0.1:8000/api/v1/categories');
        $categories = $categories_response->successful() ? $categories_response->json() : [];

        $check_in = Carbon::now()->format('Y-m-d');
        $check_out = Carbon::now()->addDays(7)->format('Y-m-d');

        $response = Http::get("http://127.0.0.1:8000/api/v1/properties?checkInDate[eq]={$check_in}&checkOutDate[eq]={$check_out}");
        $data = $response->successful() ? $response->json()['data'] : [];

        $countries = collect($data)->pluck('property_country')->unique()->shuffle()->take(6)->values()->toArray();

        usort($data, function ($a, $b) {
            return $b['page_visits'] <=> $a['page_visits']; //callback(mixed $a, mixed $b): int

        }); // usort($array, $callback):



        $properties = array_slice($data, 0, 8);
        session()->put('categories', $categories);
        return view('pages.client.homepage', compact('properties', 'countries'));
    }
}

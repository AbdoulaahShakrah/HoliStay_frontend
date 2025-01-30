<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PropertyController extends Controller
{
    private function buildQueryString(array $params): string
    {
        return http_build_query($params);
    }

    public function customSearch(Request $request)
    {
        $checkInDate = Carbon::today()->addDays(1)->toDateString();
        $checkOutDate = Carbon::today()->addDays(8)->toDateString();
        $dates = $checkInDate . " - " . $checkOutDate;

        session()->put([
            'dates' => $dates,
            'location' => $request->input('country'),
        ]);

        $queryParams = [
            "checkInDate[eq]" => $checkInDate,
            "checkOutDate[eq]" => $checkOutDate,
            "propertyCapacity[eq]" => $request->input('capacity'),
            "propertyCountry[contain]" => $request->input('country'),
            "propertyPrice[gte]" => $request->input('price'),
        ];

        return redirect()->route('properties', $queryParams);
    }

    public function generalSearch(Request $request)
    {
        $dates = explode(" - ", $request->input('dates'));
        $checkInDate = $dates[0] ?? null;
        $checkOutDate = $dates[1] ?? null;

        $guests = explode(" ", $request->input('guests', ''));
        $adults = $guests[0] ?? 0;
        $children = $guests[2] ?? 0;
        $babies = $guests[4] ?? 0;
        $capacity = $adults + $children + $babies;

        session()->put([
            'dates' => $request->input('dates'),
            'guests' => $request->input('guests'),
            'location' => $request->input('location'),
        ]);

        $queryParams = [
            "checkInDate[eq]" => $checkInDate,
            "checkOutDate[eq]" => $checkOutDate,
            "propertyCapacity[eq]" => $capacity,
            "propertyCity[contain]" => $request->input('location'),
        ];

        return redirect()->route('properties', $this->buildQueryString($queryParams));
    }

    public function properties(Request $request)
    {
        // Guardar na sessão os valores, garantindo que permanecem após o refresh
        session()->put([
            'dates' => $request->input('dates', session('dates')),
            'guests' => $request->input('guests', session('guests')),
            'location' => $request->input('location', session('location')),
        ]);

        $apiUrl = 'http://127.0.0.1:8000/api/v1/properties' . '?' . urldecode(http_build_query($request->query()));
        $response = Http::get($apiUrl);
        $properties = $response->successful() ? $response->json()['data'] : [];

        return view('pages.client.search-results', compact('properties'));
    }

    public function show($id, Request $request)
    {
        $apiUrl = 'http://127.0.0.1:8000/api/v1/properties/' . $id;

        $response = Http::get($apiUrl);
        $property = $response->successful() ? $response->json()['data'] : [];

        return view('pages.client.property-details', compact('property'));
    }
}

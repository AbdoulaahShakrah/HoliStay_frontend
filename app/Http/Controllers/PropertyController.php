<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

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
        session()->put([
            'searchType' => 'customSearch',
            'location'   => $request->input('country'),
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

    public function catagorySearch(Request $request)
    {

        $checkInDate = Carbon::today()->addDays(1)->toDateString();
        $checkOutDate = Carbon::today()->addDays(8)->toDateString();

        session()->put([
            'searchType' => 'catagorySearch',
        ]);

        $queryParams = [
            "checkInDate[eq]" => $checkInDate,
            "checkOutDate[eq]" => $checkOutDate,
            "propertyType[eq]" => $request->input('category'),
        ];

        return redirect()->route('properties', $this->buildQueryString($queryParams));
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
            'dates' => $request->input('dates', session('dates')),
            'guests' => $request->input('guests', session('guests')),
            'location' => $request->input('location'),
            'searchType' => 'generalSearch',
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
        if (session('searchType') == 'generalSearch') {
            session()->forget('checkInDate');
            session()->forget('checkOutDate');
            session()->forget('propertyCountry');

            session()->put([
                'dates' => $request->input('dates', session('dates')),
                'guests' => $request->input('guests', session('guests')),
                'location' => $request->input('location', session('location')),
            ]);
        }
        elseif(session('searchType') == 'customSearch') {
            session()->forget('dates');
            session()->forget('guests');
            session()->put([
                'checkInDate' => $request->query('checkInDate')['eq'] ?? null,
                'checkOutDate' => $request->query('checkOutDate')['eq'] ?? null,
                'location' => $request->input('location', session('location')),
            ]);
        } else {
            session()->put([
                'location' => $request->input('location', 'Tudo o Mundo')
            ]);
        }

        $apiUrl = 'http://127.0.0.1:8000/api/v1/properties' . '?' . urldecode(http_build_query($request->query())); //urldecode por causa dos caracteres especiais do url
        $response = Http::get($apiUrl);
        $properties = $response->successful() ? $response->json()['data'] : [];
        return view('pages.client.search-results', compact('properties'));
    }

    public function show($id, Request $request)
    {
        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;

        $apiUrl = 'http://127.0.0.1:8000/api/v1/properties/' . $id;


        $response = Http::get($apiUrl);
        $property = $response->successful() ? $response->json()['data'] : [];

        if ($property) {
            $pageVisits = isset($property['page_visits']) ? $property['page_visits'] + 1 : 1;
            Http::withToken($cleanToken)->patch($apiUrl, [
                'pageVisits' => $pageVisits,
            ]);
        }

        return view('pages.client.property-details', compact('property'));
    }
}

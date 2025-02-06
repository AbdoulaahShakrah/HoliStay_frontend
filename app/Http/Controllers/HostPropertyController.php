<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HostPropertyController extends Controller
{
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

        // Para cada propriedade, obter as reservas correspondentes
        foreach ($properties as &$property) {
            // Obtém as reservas para cada propriedade
            $property['reservations'] = $this->getPropertyReservations($property['property_id']);
        }

        return view('pages.host.host-homepage', compact('properties'));
    }

    public function propertyDetails($id, Request $request)
    {
        $apiUrl = 'http://127.0.0.1:8000/api/v1/properties/' . $id;

        $response = Http::get($apiUrl);
        $property = $response->successful() ? $response->json()['data'] : [];

        $reservations = $this->getPropertyReservations($id);

        // Ordenar pelo check_in_date
        usort($reservations, function ($a, $b) {
            return strtotime($a['check_in_date']) - strtotime($b['check_in_date']);
        });

        return view('pages.host.host-property-details', compact('property', 'reservations'));
    }

    public function edit($id, Request $request)
    {
        $apiUrl = 'http://127.0.0.1:8000/api/v1/properties/' . $id;

        $response = Http::get($apiUrl);
        $property = $response->successful() ? $response->json()['data'] : [];

        $amenities = $this->getAmenities();

        return view('pages.host.host-property-create', compact('property', 'amenities'));
        //return view('pages.host.host-property-details', compact('property'));
    }

    public function update($id, Request $request)
    {
        // Handle the logic for storing a property
    }

    public function create(Request $request)
    {
        $amenities = $this->getAmenities();
        return view('pages.host.host-property-create', compact('amenities'));
        //return view('pages.host.host-property-details', compact('property'));
    }

    public function store(Request $request)
    {
        // Handle the logic for storing a property
    }

    public function delete($id, Request $request)
    {
        // Handle the logic for storing a property
    }

    private function getAmenities()
    {
        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;

        $response = Http::withToken($cleanToken)->get('http://127.0.0.1:8000/api/v1/amenities');
        $amenities = $response->json()['data'];

        return $amenities;
    }

    private function getPropertyReservations($id)
    {
        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;

        $response = Http::withToken($cleanToken)->get('http://127.0.0.1:8000/api/v1/reservations/by-property?property_id=' . $id);
        // Verifica se há reservas na resposta
        $reservations = $response->json()['data'] ?? []; // Retorna um array vazio se não houver reservas

        return $reservations;
    }
}

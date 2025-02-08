<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnalyticsController extends Controller
{
    public function setAnalyticsPage()
    {
        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;
    
        // Buscar todas as propriedades do host
        $response = Http::withToken($cleanToken)->get("http://127.0.0.1:8000/api/v1/properties-by-host?host_id=" . session('host_id'));
        $properties = $response->json()['data'];

        
        $propertyReservations = []; // ['Nome da Propriedade' => Nº de Reservas]
        $totalViews = 0; // Total de visitas
        $totalReservations = 0; // Total de reservas de todas as propriedades
        $totalRevenue = 0; // Total ganho
    
        foreach ($properties as $property) {
            $totalViews += $property['page_visits'] ?? 0;
    
            $response = Http::withToken($cleanToken)->get("http://127.0.0.1:8000/api/v1/reservations/by-property?property_id=" . $property['property_id']);
            $reservations = $response->json()['data'] ?? [];
    
            $numReservations = count($reservations);
            $propertyReservations[$property['property_name']] = $numReservations;
            $totalReservations += $numReservations;
    
            foreach ($reservations as $reservation) {
                $totalRevenue += floatval($reservation['reservation_amount']);
            }
        }
      
        
        return view('pages.analytics-page', compact(
            'properties', 
            'propertyReservations', 
            'totalViews', 
            'totalReservations', 
            'totalRevenue'
        ));
    }
}

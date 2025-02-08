<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReservationController extends Controller
{

    public function my_reservations()
    {
        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;

        $response = Http::withToken($cleanToken)->get("http://127.0.0.1:8000/api/v1/reservations/by-client?client_id=" . session('client_id'));
        
        $reservations = $response->json()['data'];

        return view('pages.client.my-reservations', compact('reservations'));
    }


    public function payment($id)
    {
        return view('pages.client.payment-page');
    }


    /*
    {
    "propertyId": 21,
    "clientId": 10,
    "checkInDate": "2025-10-10 19:05:32",
    "checkOutDate": "2025-10-12 19:05:32",
    "reservationAmount": 300.00
}
    */
    public function store_reservation_payment(Request $request)
    {

        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;

        $check_in_format = DateTime::createFromFormat('d-m-Y', $request->input('check_in'));
        $check_out_format = DateTime::createFromFormat('d-m-Y', $request->input('check_out'));

        if ($check_in_format) {
            $check_in = $check_in_format->format('Y-m-d') . ' 12:00:00';
            $check_out = $check_out_format->format('Y-m-d') . ' 12:00:00';
        } else {
            $check_in = $request->input('check_in') . ' 12:00:00';
            $check_out = $request->input('check_out') . ' 12:00:00';
        }

        $response_reservations = Http::withToken($cleanToken)->post(
            "http://127.0.0.1:8000/api/v1/reservation",
            [
                "propertyId" => $request->input('property_id'),
                "clientId" => session('client_id'),
                "checkInDate" => $check_in,
                "checkOutDate" => $check_out,
                "reservationAmount" => $request->input('total_price')
            ]
        );

        $response_payment = Http::withToken($cleanToken)->post(
            "http://127.0.0.1:8000/api/v1/payment",
            [
                "reservationId" => $response_reservations->json('reservation_id'),
                "paymentMethod" => $request->input('payment_method')
            ]
        );
        session()->flash('success', 'Reservas carregadas com sucesso!');

        return redirect()->route('my.reservations');
    }

    public function reservationCancel($id){
        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;
        $response = Http::withToken($cleanToken)->patch("http://127.0.0.1:8000/api/v1/reservation/". $id, [
            "reservationStatus" => "Cancelled"
        ]);
        $response->successful() ? session()->flash('success', 'Reserva cancelada com sucesso!') : 
        session()->flash('error', 'Erro ao cancelar reserva!');
        
        return redirect()->route('my.reservations');
    }
}

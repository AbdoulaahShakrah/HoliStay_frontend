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

        session()->put(['hostName' => $properties[0]['host']['client']['client_name']]);

        // Para cada propriedade, obtem as reservas correspondentes
        foreach ($properties as &$property) {
            $property['reservations'] = $this->getPropertyReservations($property['property_id']);
        }

        return view('pages.host.host-homepage', compact('properties'));
    }

    /**
     * Display a specific resource with details.
     */
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

    /**
     * Edit a resource.
     */
    public function edit($id, Request $request)
    {
        $apiUrl = 'http://127.0.0.1:8000/api/v1/properties/' . $id;

        $response = Http::get($apiUrl);
        $property = $response->successful() ? $response->json()['data'] : [];

        $amenities = $this->getAmenities();

        return view('pages.host.host-property-create', compact('property', 'amenities'));
    }

    /**
     * Update a resource.
     */
    public function update($id, Request $request)
    {
        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;

        // Dados a serem enviados no PUT
        $propertyData = [
            'hostId' => session('host_id'),
            'propertyName' => $request->input('name'),
            'propertyCity' => $request->input('location'),
            'propertyCountry' => $request->input('country'),
            'propertyAddress' => $request->input('address'),
            'propertyBedrooms' => (int) $request->input('rooms'),
            'propertyBeds' => (int) $request->input('beds'),
            'propertyCapacity' => (int) $request->input('capacity'),
            'propertyBathrooms' => (int) $request->input('bathrooms'),
            'cancellationPolicy' => (int) $request->input('days'),
            'propertyDescription' => $request->input('description'),
            'propertyPrice' => (float) $request->input('price'),
            'propertyType' => $request->input('property_type'),
            'propertyStatus' => $request->input('status', 'Available'), // Adicionado
            'amenities' => $request->input('amenities', []),
        ];

        $response = Http::withToken($cleanToken)
            ->put("http://127.0.0.1:8000/api/v1/properties/" . $id, $propertyData);

        if ($response->successful()) {

            // Remover fotos já existentes que foram excluídas
            $removedPhotos = json_decode($request->input('removed_photos', '[]'), true);
            if (!empty($removedPhotos)) {
                foreach ($removedPhotos as $photoId) {
                    $photoPath = public_path($photoId);
                    if (file_exists($photoPath)) {
                        unlink($photoPath); // Remove a foto fisicamente
                    }

                    Http::withToken($cleanToken)
                        ->delete("http://127.0.0.1:8000/api/v1/photos/" . $photoId);
                }
            }

            // Adicionar fotos novas (Verifica se há fotos e faz o upload)
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $extension = $photo->getClientOriginalExtension(); // Obtém a extensão correta
                    $photoName = intval(microtime(true) * 1000) . '.' . $extension;                   
                    $destinationPath = public_path('images/homepage'); // Define o caminho da pasta                   
                    $photo->move($destinationPath, $photoName); // Move o arquivo para `public/images/homepage/`                   
                    $photoPath = 'images/homepage/' . $photoName; // Caminho relativo para guardar na base de dados
                    // Enviar o caminho para a API
                    $photoData = [
                        'propertyId' => $id,
                        'propertyUrl' => $photoPath,
                    ];

                    Http::withToken($cleanToken)
                        ->post("http://127.0.0.1:8000/api/v1/photos", $photoData);
                }
            }
            return redirect()->route('hostProperties')
                ->with('success', 'Propriedade atualizada com sucesso!');
        } else {
            return back()->withErrors(['error' => 'Erro ao atualizar a propriedade.']);
        }
    }

    /**
     * Create new a resource.
     */
    public function create(Request $request)
    {
        $amenities = $this->getAmenities();
        return view('pages.host.host-property-create', compact('amenities'));
    }

    /**
     * Store a new a resource.
     */
    public function store(Request $request)
    {
        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;

        // Dados a serem enviados no POST
        $propertyData = [
            'hostId' => session('host_id'),
            'propertyName' => $request->input('name'),
            'propertyCity' => $request->input('location'),
            'propertyCountry' => $request->input('country'),
            'propertyAddress' => $request->input('address'),
            'propertyBedrooms' => (int) $request->input('rooms'),
            'propertyBeds' => (int) $request->input('beds'),
            'propertyCapacity' => (int) $request->input('capacity'),
            'propertyBathrooms' => (int) $request->input('bathrooms'),
            'cancellationPolicy' => (int) $request->input('days'),
            'propertyDescription' => $request->input('description'),
            'propertyPrice' => (float) $request->input('price'),
            'propertyType' => $request->input('property_type'),
            'propertyStatus' => $request->input('status', 'Available'),
        ];

        // Criar a propriedade
        $response = Http::withToken($cleanToken)
            ->post("http://127.0.0.1:8000/api/v1/properties", $propertyData);

        if ($response->successful()) {
            $property = $response->json()['data'];
            $propertyId = $property['property_id'];

            // Associar comodidades (amenities)
            foreach ($request->input('amenities', []) as $amenity) {
                $amenityData = [
                    'propertyId' => $propertyId,
                    'amenityId' => $amenity,
                ];
                Http::withToken($cleanToken)
                    ->post("http://127.0.0.1:8000/api/v1/propertyAmenities", $amenityData);
            }

            // Verifica se há fotos e faz o upload
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    // Obtém a extensão correta
                    $extension = $photo->getClientOriginalExtension();
                    // Gera um nome único baseado no timestamp corretamente
                    $photoName = intval(microtime(true) * 1000) . '.' . $extension;
                    // Define o caminho correto dentro de `public/`
                    $destinationPath = public_path('images/homepage');
                    // Move o arquivo para `public/images/homepage/`
                    $photo->move($destinationPath, $photoName);
                    // Caminho relativo para guardar na base de dados
                    $photoPath = 'images/homepage/' . $photoName;
                    // Enviar o caminho para a API
                    $photoData = [
                        'propertyId' => $propertyId,
                        'propertyUrl' => $photoPath,
                    ];

                    Http::withToken($cleanToken)
                        ->post("http://127.0.0.1:8000/api/v1/photos", $photoData);
                }
            }
            return redirect()->route('hostProperties')
                ->with('success', 'Propriedade criada com sucesso!');
        } else {
            return back()->withErrors(['error' => 'Erro ao criar a propriedade.']);
        }
    }

    /**
     * Soft delete a resource.
     */
    public function delete($id, Request $request)
    {
        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;

        $response = Http::withToken($cleanToken)->delete("http://127.0.0.1:8000/api/v1/properties/" . $id);
        if ($response->successful()) {
            return redirect()->route('hostProperties')
                ->with('success', 'Propriedade eliminada com sucesso!');
        } else {
            return back()->withErrors(['error' => 'Erro ao eliminar a propriedade.']);
        }
    }

    /**
     * Private fun to get All amenities list.
     */
    private function getAmenities()
    {
        $fullToken = session('access_token');
        $tokenParts = explode('|', $fullToken);
        $cleanToken = $tokenParts[1] ?? $fullToken;

        $response = Http::withToken($cleanToken)->get('http://127.0.0.1:8000/api/v1/amenities');
        $amenities = $response->json()['data'];

        return $amenities;
    }

    /**
     * Private fun to get property reservations.
     */
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

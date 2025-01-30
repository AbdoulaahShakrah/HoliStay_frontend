<link rel="stylesheet" href="{{ asset('pages/css/client/property-details.css') }}">
@extends('layouts.client-layout')

@section('title', 'Property Details - HOLISTAY')

@section('content')
<div class="property-details">
    <h1 class="property-title">{{ $property['property_name'] }}</h1>
    <div class="slider-location">
        <x-property-slider :photos="$property['photos']" />
    </div>

    <div class="property-info">
        <p class="property-location">Moradia em: {{ $property['property_city'] }}, {{ $property['property_country'] }}</p>

        <ul class="property-info-list">
            <div class="info-list-item">
                <i class="fa fa-users" aria-hidden="true"></i>
                <li>Cabe <strong>{{ $property['property_capacity'] }}</strong> Hóspedes </li>
            </div>
            <div class="info-list-item">
                <i class="fa fa-door-closed" aria-hidden="true"></i>
                <li><strong>{{ $property['property_bedrooms'] }}</strong> Quartos</li>
            </div>
            <div class="info-list-item">

            <i class="fa fa-bed" aria-hidden="true"></i>
            <li><strong>{{ $property['property_beds'] }}</strong> Camas</li>
            </div>
            <div class="info-list-item">
            <i class="fa fa-bath" aria-hidden="true"></i>
                <li><strong>{{ $property['property_bathrooms'] }}</strong> Casas de banho</li>
            </div>
        </ul>

        <p class="property-description">{{ $property['property_description'] }}</p>

        <div class="amenities">
            @foreach ($property['amenities'] as $amenity)
            <span class="amenity">{{ $amenity['name'] }}</span>
            @endforeach
        </div>

        <p class="cancellation-policy">&#x2714; Cancelamento até dia {{ $property['cancellation_policy'] }}</p>
    </div>

    <div class="property-pricing">
        <h2>&euro;{{ $property['property_price'] }} / Noite</h2>
        <span>{{session('dates')}}</span>
        <button type="submit" class="btn-reserve">Reservar</button>
    </div>
</div>
@endsection
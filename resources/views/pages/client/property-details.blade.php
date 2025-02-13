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
        <p class="property-location"> <i class="fas fa-location-dot"></i> Moradia em: {{ $property['property_city'] }}, {{ $property['property_country'] }}</p>

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
            <span class="amenity"> <i class="fas fa-{{$amenity['name']}}" aria-hidden="true"></i>
                {{ $amenity['name'] }}</span>
            @endforeach
        </div>
        @php
        use Carbon\Carbon;
        $dates = session('dates') ?? '';
        $dates = is_string($dates) ? explode(' - ', $dates) : [];
        $check_in = session('checkInDate')?? $dates[0] ?? null;
        $check_out = session('checkOutDate') ?? $dates[1] ?? null;

        $cancelation_date = $check_in ? Carbon::parse($check_in)->addDays(-$property['cancellation_policy']) : "{$property['cancellation_policy']} dias antes da data da reserva"; ;
        @endphp
        <p class="cancellation-policy">&#x2714; Cancelamento até dia {{ $cancelation_date  }}</p>
    </div>

    <div class="property-pricing">
        <h2>&euro;{{ $property['property_price'] }} / Noite</h2>
        @if($check_in && $check_out)
        <div class="dates">
            <p>Entrada no dia: {{$check_in}}</p>
            <p> | </p>
            <p>Saída no dia: {{ $check_out}}</p>
        </div>

        @php
        $taxes = 0;
        @endphp

        <div class="value-item">
            @foreach ($property['taxes'] as $tax)
            <p class="tax-name">{{$tax['tax_name']}}: </p>
            <p class="tax-value">€{{$tax['tax_value']}}</p>
            @php
            $taxes += $tax['tax_value'];
            @endphp
            @endforeach
        </div>

        @php
        $total_w_tax = session('difference') * $property['property_price'] + $taxes;
        $total = session('difference') * $property['property_price'];
        @endphp

        <div class="value-item">
            <p class="tax-name">{{session('difference')}} Dias x {{$property['property_price']}}</p>
            <p class="tax-value">€{{$total}}</p>
        </div>

        <div class="line-div"></div>
        <p>Valor total: <span class="total-value">€{{$total_w_tax}}</span></p>
        <form method="POST" action="{{ route('payment', ['id', $property['property_id']]) }}">
            @csrf
            <input type="hidden" name="property_id" value="{{ $property['property_id'] }}">
            <input type="hidden" name="property_name" value="{{ $property['property_name'] }}">
            <input type="hidden" name="property_price" value="{{ $property['property_price'] }}">
            <input type="hidden" name="check_in" value="{{ $check_in }}">
            <input type="hidden" name="check_out" value="{{ $check_out }}">
            <input type="hidden" name="total_price" value="{{ $total_w_tax }}">
            @if(session('access_token'))
            <button type="submit" class="btn-reserve">Reservar</button>
            @else
            <a href="/login" class="btn-reserve">Reservar</a>

            @endif
        </form>
        @else
        <p class="error">Não selecionou nenhuma data</p>
        @endif

    </div>
</div>
@endsection
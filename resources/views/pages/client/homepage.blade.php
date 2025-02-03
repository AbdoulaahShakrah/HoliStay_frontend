<link rel="stylesheet" href="{{ asset('pages/css/client/homepage.css') }}">
@extends('layouts.client-layout')

@section('title', 'Home - HOLISTAY')

@section('content')



<div class="properties-section">
    <h3>Destinos Populares para Casais</h3>
    <div class="properties-grid">
        @foreach(array_slice($countries, 0, 3) as $country)
        <div class="property-card" onclick="submitSearch('{{ $country }}', 100, 2)">
            <!--<img src="{{ asset('images/homepage/' . strtolower($country) . '.webp') }}" loading="lazy" alt="Imagem do Alojamento">-->
            <img src="{{ asset('images/homepage/3.webp') }}" loading="lazy" alt="Imagem do Alojamento">
            <div class="property-content">
                <h4>{{ $country }}</h4>
                <p>Casa de férias perfeita para dois em {{ $country }}.</p>
                <p class="price">A partir de €100 por noite</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="properties-section">
    <h3>Destinos Populares para Famílias</h3>
    <div class="properties-grid">
        @foreach(array_slice($countries, 3, 3) as $country)
        <div class="property-card" onclick="submitSearch('{{ $country }}', 900, 7)">
            <!--<img src="{{ asset('images/homepage/' . strtolower($country) . '.webp') }}" loading="lazy" alt="Imagem do Alojamento">-->
            <img src="{{ asset('images/homepage/2.webp') }}" loading="lazy" alt="Imagem do Alojamento">
            <div class="property-content">
                <h4>{{ $country }}</h4>
                <p>Casa espaçosa para famílias grandes em {{ $country }}.</p>
                <p class="price">A partir de €900 por noite</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

<h3 class="most-visited"> Casas Mais Visitadas </h3>
<div class="properties">
    @foreach($properties as $property)
    <x-property-card :property="$property" />
    @endforeach
</div>

<form id="searchForm" method="POST" --action="{{ route('customSearch') }}" style="display: none;">
    @csrf
    <input type="hidden" name="country" id="country">
    <input type="hidden" name="price" id="price">
    <input type="hidden" name="capacity" id="capacity">
</form>

<script>
    function submitSearch(country, price, capacity) {
        document.getElementById('country').value = country;
        document.getElementById('price').value = price;
        document.getElementById('capacity').value = capacity;
        document.getElementById('searchForm').submit();
    }
</script>

@endsection 
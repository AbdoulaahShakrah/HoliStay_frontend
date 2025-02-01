<link rel="stylesheet" href="{{ asset('pages/css/host/host-homepage.css') }}">
@extends('layouts.host-layout')

@section('title', 'Host - HOLISTAY')

@section('content')
<div class="properties-section">
    <h3>Alojamentos para Casais</h3>
    <div class="properties-grid">
       
        <div class="property-card" onclick="submitSearch('Iceland', 74, 2)">
            <img src="{{ asset('images/homepage/1.webp') }}" loading="lazy" alt="Imagem do Alojamento">
            <div class="property-content">
                <h4>Iceland</h4>
                <p>Casa de férias para 2 pessoas, com sauna, com animais de estimação</p>
                <p class="price">A partir de €74 por noite</p>
                <div class="property-rating">
                    <span class="star">★</span> 5
                </div>
            </div>
        </div>
        <div class="property-card" onclick="submitSearch('France', 110)">
            <img src="{{ asset('images/homepage/2.webp') }}" loading="lazy" alt="Imagem do Alojamento">
            <div class="property-content">
                <h4>França</h4>
                <p>Casa de férias para 2 pessoas, com sauna, com animais de estimação</p>
                <p class="price">A partir de €110 por noite</p>
                <div class="property-rating">
                    <span class="star">★</span> 5
                </div>
            </div>
        </div>
        <div class="property-card" onclick="submitSearch('Canada', 200)">
            <img src="{{ asset('images/homepage/3.webp') }}" loading="lazy" alt="Imagem do Alojamento">
            <div class="property-content">
                <h4>Canada</h4>
                <p>Casa de férias para 2 pessoas, com sauna, com animais de estimação</p>
                <p class="price">A partir de €200 por noite</p>
                <div class="property-rating">
                    <span class="star">★</span> 5
                </div>
            </div>
        </div>
    </div>
</div>

<div class="properties-section">
    <h3>Alojamentos para Familias</h3>
    <div class="properties-grid" onclick="submitSearch('Grécia', 200)">
        <div class="property-card">
            <img src="{{ asset('images/homepage/4.webp') }}" loading="lazy" alt="Imagem do Alojamento">
            <div class="property-content">
                <h4>Grécia</h4>
                <p>Casa de férias para 2 pessoas, com varanda, com animais de estimação</p>
                <p class="price">A partir de €110 por noite</p>
                <div class="property-rating">
                    <span class="star">★</span> 5
                </div>
            </div>
        </div>
        <div class="property-card" onclick="submitSearch('Catar', 17)">
            <img src="{{ asset('images/homepage/5.webp') }}" loading="lazy" alt="Imagem do Alojamento">
            <div class="property-content">
                <h4>Catar</h4>
                <p>Casa de férias para 2 pessoas, com varanda, com animais de estimação</p>
                <p class="price">A partir de €17 por noite</p>
                <div class="property-rating">
                    <span class="star">★</span> 5
                </div>
            </div>
        </div>
        <div class="property-card" onclick="submitSearch('Portugal', 300)">
            <img src="{{ asset('images/homepage/6.webp') }}" loading="lazy" alt="Imagem do Alojamento">
            <div class="property-content">
                <h4>Portugal</h4>
                <p>Casa de férias para 2 pessoas, com varanda, com animais de estimação</p>
                <p class="price">A partir de €300 por noite</p>
                <div class="property-rating">
                    <span class="star">★</span> 5
                </div>
            </div>
        </div>
    </div>
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
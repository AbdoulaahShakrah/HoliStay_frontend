<link rel="stylesheet" href="{{ asset('pages/css/host/host-homepage.css') }}">
@extends('layouts.host-layout')

@section('title', 'Host - HOLISTAY')

@section('content')
<div class="properties-section">
    <h2>As minhas propriedades</h2>
    <div class="properties-grid">


        <div class="property-card">
            <div class="top-side">
                <div class="image">
                    <img src="{{ asset('images/homepage/1.webp') }}" loading="lazy" alt="Imagem do Alojamento">
                </div>
                <div class="price-content">
                    <p class="active-price">Active Price</p>
                    <h4 class="price">150€</h4>
                </div>
                <div class="card-buttons">
                    <button class="edit-btn">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="delete-btn">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="bottom-side">
                <div class="title">
                    <p class="property-type">Apartment</p>
                    <h4 class="location">Beja, Portugal</h4>
                </div>
                <div class="more-details">
                    <a href="#">Ver Mais Detalhes</a>
                </div>
                <div class="status">
                <button class="reserved-btn">✔ Reservado</button>
                </div>
            </div>
        </div>

        <div class="property-card">
            <div class="top-side">
                <div class="image">
                    <img src="{{ asset('images/homepage/4.webp') }}" loading="lazy" alt="Imagem do Alojamento">
                </div>
                <div class="price-content">
                    <p class="active-price">Active Price</p>
                    <h4 class="price">200€</h4>
                </div>
                <div class="card-buttons">
                    <button class="edit-btn">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="delete-btn">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="bottom-side">
                <div class="title">
                    <p class="property-type">House</p>
                    <h4 class="location">Lisboa, Portugal</h4>
                </div>
                <div class="more-details">
                    <a href="#">Ver Mais Detalhes</a>
                </div>
                <div class="status">
                <button class="reserved-btn">✔ Reservado</button>
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
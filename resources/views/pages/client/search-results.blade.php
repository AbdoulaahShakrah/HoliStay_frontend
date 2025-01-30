<link rel="stylesheet" href="{{ asset('pages/css/client/search-results.css') }}">

@extends('layouts.client-layout')

@section('title', 'Search Result - HOLISTAY')

@section('content')

<div class="container">
    
    <div class="price-filter-container">
        <div class="search-location">Pesquisa em {{ session('location')}} </div>
        <form action="" class="price-form">
            <div class="input-group">
                <label for="min-price">Min Price</label>
                <input type="number" id="min-price" name="min-price" placeholder="€0" />
            </div>

            <div class="input-group">
                <label for="max-price">Max Price</label>
                <input type="number" id="max-price" name="max-price" placeholder="€1000" />
            </div>

            <button type="submit" class="filter-btn">Apply Filter</button>
        </form>
    </div>




    @if(empty($properties))
    <!-- Aqui vem o codigo de não existem propriedades -->
    <h1>Empty</h1>
    @else
    <!-- Aqui vem o código de existem propriedades -->
    <div class="properties">
        @foreach($properties as $property)
        <x-property-card :property="$property" />
        @endforeach
    </div>
    @endif
</div>

@endsection
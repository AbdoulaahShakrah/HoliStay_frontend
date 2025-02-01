<link rel="stylesheet" href="{{ asset('pages/css/client/search-results.css') }}">

@extends('layouts.client-layout')

@section('title', 'Search Result - HOLISTAY')

@section('content')

<div class="container">

    <div class="price-filter-container">
        <div class="search-location">Pesquisa em {{ session('location')}} </div>

        <div class="price-filter-container">
            <x-price-range />
        </div>

    </div>




    @if(empty($properties))
    <!-- Aqui vem o codigo de não existem propriedades -->
    <h1>Não existem propriedades para sua pesquisa</h1>
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
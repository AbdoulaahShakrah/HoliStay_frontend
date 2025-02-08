<link rel="stylesheet" href="{{ asset('pages/css/client/search-results.css') }}">

@extends('layouts.client-layout')

@section('title', 'Search Result - HOLISTAY')

@section('content')

<div class="container">

    <div class="price-filter-container">
        @if(session('location'))
            <div class="search-location">Pesquisa em {{ session('location')}} </div>
        @endif
        <div class="price-filter-container">
            <x-price-range />
        </div>

    </div>




    @if(empty($properties))
    <div style="margin: 40px auto; padding: 20px; max-width: 600px; text-align: center; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px;">
        <h1 style="font-size: 28px; color: #555; margin-bottom: 10px;">Nenhuma propriedade encontrada</h1>
        <p style="font-size: 16px; color: #777;">
            Infelizmente, não existem propriedades para a sua pesquisa.<br>
            Tente ajustar os filtros e pesquisar novamente.
        </p>
    </div>
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
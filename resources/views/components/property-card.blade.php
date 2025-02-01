<link rel="stylesheet" href="{{ asset('components/css/property-card.css') }}">

<div class="property">
<a class="property-link" href="{{ route('property.details', ['id' => $property['property_id']])}}">
        <!--@if(isset($property['photos']) && count($property['photos']) > 0)
            <img src="{{ $property['photos'][0]['photo_url'] }}" alt="Imagem da Propriedade">
        @else
            <img src="{{ asset('images/default-placeholder.png') }}" alt="Imagem Indisponível">
        @endif-->
        <img src="{{ asset('images/homepage/1.webp') }}" alt="Imagem do Alojamento">

        <div class="details">
            <h2>{{ $property['property_name'] }}</h2>
            <p>{{ $property['property_country'] }}, {{ $property['property_city'] }}</p>
            <p class="price">€{{ number_format($property['property_price'], 2, ',', '.') }}</p>
        </div>
    </a>
</div>

<link rel="stylesheet" href="{{ asset('components/css/host-property-card.css') }}">

<div class="property">
<a class="property-link" href="{{ route('property.details', ['id' => $property['property_id'], 'dates' => session('dates')]), 'guests' => se}}">
        <img src="{{ asset('images/homepage/1.webp') }}" alt="Imagem do Alojamento">

        <div class="details">
            <h2>{{ $property['property_name'] }}</h2>
            <p>{{ $property['property_country'] }}, {{ $property['property_city'] }}</p>
            <p class="price">€{{ number_format($property['property_price'], 2, ',', '.') }}</p>
        </div>
    </a>
</div>
<link rel="stylesheet" href="{{ asset('components/css/host-property-card.css') }}">

<div class="properties-grid">
    <div class="property-card">
        <div class="top-side">
            <div class="image">
                <img src="{{ asset('images/homepage/1.webp') }}" loading="lazy" alt="Imagem do Alojamento">
            </div>
            <div class="price-content">
                <p class="active-price">Active Price</p>
                <h4 class="price">{{ $property['property_price'] }} €</h4>
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
                <p class="property-type">{{ $property['property_name'] }}</p>
                <p class="property-type">{{ $property['property_type'] }}</p>
                <h4 class="location">{{ $property['property_city'] }}, {{ $property['property_country'] }}</h4>
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
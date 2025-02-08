<link rel="stylesheet" href="{{ asset('pages/css/host/host-property-details.css') }}">
@extends('layouts.host-layout')

@section('title', 'Host Property Details - HOLISTAY')

@section('content')
<div class="property-details">
    <h1 class="property-title">{{ $property['property_name'] }}</h1>

    <div class="slider-location">
        <x-property-slider :photos="$property['photos']" />
    </div>

    <div class="status">
        <button id="propertyStatusBtn" class="reserved-btn">
            <span id="statusIcon">✔</span> <span id="statusText">{{ $property['property_status'] }}</span>
        </button>
    </div>

    <div class="property-info">
        <div class="property-left">
            <h2 class="title-address"> <i class="fas fa-location-dot"></i> Endereço:</h2>
            <p class="property-address">{{ $property['property_address'] }}</p>
            <p class="property-address">{{ $property['property_city'] }}, {{ $property['property_country'] }}</p>

            <h2 class="title-price">€ Preço:</h2>
            <h1 class="property-price">{{ $property['property_price'] }}€ / Dia</h1>

            <h2 class="title-capacity"><i class="fa fa-users" aria-hidden="true"></i> Capacidade:</h2>
            <p>Hospedes: {{ $property['property_capacity'] }}</p>
            <p>Quartos: {{ $property['property_bedrooms'] }}</p>
            <p>Camas: {{ $property['property_beds'] }}</p>
            <p>WC's: {{ $property['property_bathrooms'] }}</p>

            <div class="amenities">
                <h2 class="title-price">Comodidades:</h2>
                <ul class="amenities-list">
                    @foreach ($property['amenities'] as $amenity)
                    <li>
                        <i class="fa fa-{{ $amenity['name'] }}" aria-hidden="true"></i> {{ $amenity['name'] }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="property-right">
            <div class="property-right-info">
                <h2 class="title-address">Detalhes da Reserva:</h2>

                @if (!empty($reservations))
                <h3 class="reserved-by">Reservado por:</h3>
                <p id="client_id">{{ $reservations[0]['client']['client_name'] }}</p>

                <h3 class="dates">Datas:</h3>
                <p>Check-in: <span id="check_in_date">{{ $reservations[0]['check_in_date'] }}</span></p>
                <p>Check-out: <span id="check_out_date">{{ $reservations[0]['check_out_date'] }}</span></p>

                <h3 class="guest-contact">Contacto:</h3>
                <p id="contact">{{ $reservations[0]['client']['phone_number'] }}</p>

                <h3 class="value-payed">Valor Pago (€):</h3>
                <p><span id="reservation_amount">{{ $reservations[0]['reservation_amount'] }}</span> €</p>
                @else
                <p>De momento não exitem reservas</p>
                <p>para esta propriedade.</p>
                @endif

                <!-- Botões de navegação entre reservas -->
                <div class="buttons-container">
                    <button class="prevBtn" id="prevBtn">← Anterior</button>
                    <button class="nextBtn" id="nextBtn">Próximo →</button>
                </div>

                <!-- Todas as reservas no atributo data -->
                <div id="reservationsData" data-reservations='@json($reservations)'></div>
            </div>
            <a href="{{ route('hostProperty.edit', ['id' => $property['property_id']]) }}" class="btn-edit">Editar Propriedade</a>
        </div>
    </div>
</div>
@endsection

<!--Função para navegar nas reservas existentes para a propriedade-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let reservations = JSON.parse(document.getElementById('reservationsData').dataset.reservations);
        let currentIndex = 0;

        let prevBtn = document.getElementById('prevBtn');
        let nextBtn = document.getElementById('nextBtn');

        // Oculta os botões se houver 0 ou 1 reserva
        if (reservations.length <= 1) {
            prevBtn.style.display = "none";
            nextBtn.style.display = "none";
            return; // Para evitar a execução desnecessária do restante do script
        }

        function updateReservation(index) {
            document.getElementById('client_id').innerText = reservations[index]['client_id'];
            document.getElementById('check_in_date').innerText = reservations[index]['check_in_date'];
            document.getElementById('check_out_date').innerText = reservations[index]['check_out_date'];
            document.getElementById('contact').innerText = reservations[index]['client_id'];
            document.getElementById('reservation_amount').innerText = reservations[index]['reservation_amount'];
        }

        prevBtn.addEventListener("click", function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateReservation(currentIndex);
            }
        });

        nextBtn.addEventListener("click", function() {
            if (currentIndex < reservations.length - 1) {
                currentIndex++;
                updateReservation(currentIndex);
            }
        });
    });
</script>

<!-- Script para ajustar o icone e côr do campo do estado da propriedade (Ocupado/Disponivel)-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Seleciona o elemento que contém os dados das reservas
        let reservationsData = document.getElementById("reservationsData");
        let reservations = JSON.parse(reservationsData.dataset.reservations);

        // Seleciona os elementos do botão de status
        let statusBtn = document.getElementById("propertyStatusBtn");
        let statusText = document.getElementById("statusText");
        let statusIcon = document.getElementById("statusIcon");

        function getPropertyStatus() {
            let today = new Date();
            let hasFutureReservation = false;

            for (let reservation of reservations) {
                let checkInDate = new Date(reservation.check_in_date);
                let checkOutDate = new Date(reservation.check_out_date);

                if (today >= checkInDate && today <= checkOutDate) {
                    return "Ocupado"; // A propriedade está ocupada no momento
                }

                if (checkInDate > today) {
                    hasFutureReservation = true; // Pelo menos uma reserva futura existe
                }
            }

            return hasFutureReservation ? "Reservado" : "Disponível";
        }

        function updateStatusUI(status) {
            if (status === "Ocupado") {
                statusText.innerText = "Ocupado";
                statusBtn.style.backgroundColor = "#dc3545"; // Vermelho
                statusIcon.innerText = "✖"; // Ícone de X para ocupado
            } else if (status === "Reservado") {
                statusText.innerText = "Reservado";
                statusBtn.style.backgroundColor = "#ffc107"; // Amarelo
                statusIcon.innerText = "🕒"; // Ícone de relógio para reservado
            } else {
                statusText.innerText = "Disponível";
                statusBtn.style.backgroundColor = "#28a745"; // Verde
                statusIcon.innerText = "✔"; // Checkmark para disponível
            }
        }

        // Atualiza o estado com base nas reservas
        updateStatusUI(getPropertyStatus());
    });
</script>

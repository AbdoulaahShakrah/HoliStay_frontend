<link rel="stylesheet" href="{{asset('components/css/my-reservation-card.css')}}">

<div class="my-reservation-card">
    <div class="top-side">
        <div class="property-details">
            <img src="{{ asset('images/homepage/1.webp') }}" alt="">
            <div class="property-info">
                <h2>{{$reservation['property']['property_name']}}</h2>
                <p>{{$reservation['property']['property_address']}}</p>
            </div>
        </div>
        <p>Data de entrada e saida <span class="date"> {{$reservation['check_in_date']}} </span> || <span> {{$reservation['check_in_date']}} </span></p>
    </div>
    <div class="center-side">
        <div class="reservation-info">
            <h2> Informações da reserva</h2>
            <p>Nome do cliente: <span>Luis de roxa</span></p>
            <p>Telefone: <span> 912345678 </span></p>
            <p>Número de hóspedes: <span>{{$reservation['property']['property_capacity']}}</span></p>
            <p>Preço total: €<span class="price"> {{$reservation['reservation_amount']}} </p>
        </div>
        @php
        $checkInDate = \Carbon\Carbon::parse($reservation['check_in_date']);
        $checkOutDate = \Carbon\Carbon::parse($reservation['check_out_date']);
        $currentDate = \Carbon\Carbon::now();

        $status = ($currentDate->gt($checkOutDate)) ? 'Passou' : 'Ativo';
        $situation = ($currentDate->gt($checkInDate)) ? 'Check-in feito' : 'Aguardando check-in';
        $statusColor = ($status == 'Passou') ? '#dc3545' : '#28a745';

        @endphp
        <div class="reservations-status" style="background-color: '{{$statusColor}}';">
            <!-- '{{$statusColor}}'-->
            <p>{{ $status }}</p>
        </div>
    </div>
    <div class="bottom-side">
        <div class="reservations-actions">
            <p>Situação atual: <span>{{ $situation }}</span></p>
        </div>
    </div>
</div>
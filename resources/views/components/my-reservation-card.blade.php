<link rel="stylesheet" href="{{ asset('components/css/my-reservation-card.css') }}">

<div class="my-reservation-card">
    <div class="top-side">
        <div class="property-details">
            <img src="{{ asset($reservation['property']['photos'][0]['photo_url'] ?? '') }}" alt="Foto da propriedade">
            <div class="property-info">
                <h2>{{ $reservation['property']['property_name'] }}</h2>
                <p>{{ $reservation['property']['property_address'] }}</p>
            </div>
        </div>
        <p class="checkin-checkout">Data de entrada e saída:
            <i class="fas fa-calendar-alt"></i>

            <span class="date">{{ $reservation['check_in_date'] }}</span> ||
            <i class="fas fa-calendar-alt"></i>

            <span class="date">{{ $reservation['check_out_date'] }}</span>
        </p>
    </div>

    <div class="center-side">
        <div class="reservation-info">
            <h2>Informações da reserva</h2>
            <p>Nome do cliente: <span>{{ $reservation['property']['host']['client']['client_name'] }}</span></p>
            <p>Telefone: <span>{{ $reservation['property']['host']['client']['phone_number'] }}</span></p>
            <p>Número de hóspedes: <span>{{ $reservation['property']['property_capacity'] }}</span></p>
            <p>Preço total: €<span class="price">{{ $reservation['reservation_amount'] }}</span></p>
        </div>

        @php
        use Carbon\Carbon;

        $checkInDate = Carbon::parse($reservation['check_in_date']);
        $checkOutDate = Carbon::parse($reservation['check_out_date']);
        $currentDate = Carbon::now();
        $cancellationPolicyDays = $reservation['property']['cancellation_policy'] ?? 0;

        // Determina o estado da reserva
        $status = $currentDate->gt($checkOutDate) ? 'Passou' : 'Ativo';
        $situation = $currentDate->gt($checkInDate) ? 'Check-in feito' : 'Aguardando check-in';
        $statusColor = $status == 'Passou' ? '#dc3545' : '#28a745';

        $canCancel = $currentDate->lt($checkInDate->subDays($cancellationPolicyDays));
        @endphp

        <div class="reservations-status" style="background-color: {{ $statusColor }};">
            <p>{{ $status }}</p>
        </div>
    </div>

    <div class="bottom-side">
        <div class="reservations-actions">
            <p>Situação atual: <span>{{ $reservation['reservation_status'] }}</span></p>

            @if($canCancel && $reservation['reservation_status'] != 'Cancelled')
            <form action="{{ route('reservations.cancel', $reservation['reservation_id']) }}" method="POST">
                @csrf
                <button type="submit" class="cancel-button">Cancelar Reserva</button>
            </form>
            @endif
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('components/css/my-reservation-card.css') }}">

<div class="my-reservation-card">
    <div class="top-side">
        <div class="property-details">
            <img src="{{ asset($reservation['property']['photos'][0]['photo_url'] ?? '') }}" alt="Propriedade sem imagem disponivel">

            <div class="property-info">
                <h2>{{ $reservation['property']['property_name'] }}</h2>
                <p>{{ $reservation['property']['property_address'] }}</p>
            </div>
        </div>
        <p class="checkin-checkout">Data de entrada e saída:
            <i class="fas fa-calendar-alt"></i>

            <span class="date">{{ $reservation['check_in_date'] }}</span> ||
            <i class="fas fa-calendar-alt"></i>

            <span class="date">{{ $reservation['check_out_date'] }}</span>
        </p>
    </div>

    <div class="center-side">
        <div class="reservation-info">
            <h2>Informações da reserva</h2>
            <p>Nome do cliente: <span>{{ $reservation['property']['host']['client']['client_name'] }}</span></p>
            <p>Telefone: <span>{{ $reservation['property']['host']['client']['phone_number'] }}</span></p>
            <p>Número de hóspedes: <span>{{ $reservation['property']['property_capacity'] }}</span></p>
            <p>Preço total: €<span class="price">{{ $reservation['reservation_amount'] }}</span></p>
        </div>

        @php

        $checkInDate = Carbon::parse($reservation['check_in_date']);
        $checkOutDate = Carbon::parse($reservation['check_out_date']);
        $currentDate = Carbon::now();
        $cancellationPolicyDays = $reservation['property']['cancellation_policy'] ?? 0;

        // Determina o estado da reserva
        $status = $currentDate->gt($checkOutDate) ? 'Passou' : 'Ativo';
        $situation = $currentDate->gt($checkInDate) ? 'Check-in feito' : 'Aguardando check-in';
        $statusColor = $status == 'Passou' ? '#dc3545' : '#28a745';

        $canCancel = $currentDate->lt($checkInDate->subDays($cancellationPolicyDays));
        @endphp

        <div class="reservations-status" style="background-color: {{ $statusColor }};">
            <p>{{ $status }}</p>
        </div>
    </div>

    <div class="bottom-side">
        <div class="reservations-actions">
            <p>Situação atual: <span>{{ $reservation['reservation_status'] }}</span></p>

            @if($canCancel && $reservation['reservation_status'] != 'Cancelled')
            <form action="{{ route('reservations.cancel', $reservation['reservation_id']) }}" method="POST">
                @csrf
                <button type="submit" class="cancel-button">Cancelar Reserva</button>
            </form>
            @endif
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".cancel-button").forEach(button => {
            button.addEventListener("click", function (event) {
                event.preventDefault();  // Previne a submissão imediata do formulário

                Swal.fire({
                    title: "Tem certeza que pretende cancelar a sua reserva?",
                    text: "Esta ação não pode ser desfeita!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sim, remover!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submete o formulário após a confirmação
                        this.closest('form').submit();  // Envia o formulário associado ao botão
                    }
                });
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

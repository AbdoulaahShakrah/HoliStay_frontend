<link rel="stylesheet" href="{{ asset('components/css/host-property-card.css') }}">

<div class="properties-grid">
    <div class="property-card">
        <div class="top-side">
            <div class="image">
                <img src="{{ asset($property['photos'][0]['photo_url'] ?? '') }}" loading="lazy" alt="Alojamento sem imagem disponível!">
            </div>
            <div class="price-content">
                <p class="active-price">Preço diário:</p>
                <h4 class="price">{{ $property['property_price'] }} €</h4>
            </div>
            <div class="card-buttons">
                <button class="edit-btn">
                    <a href="{{ route('hostProperty.edit', ['id' => $property['property_id']]) }}" class="fas fa-edit"></a>
                </button>
                <button class="delete-btn delete-property" data-id="{{ $property['property_id'] }}">
                    <a href="#" class="fas fa-trash"></a>
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
                <a href="{{ route('hostProperty.details', ['id' => $property['property_id']]) }}">Ver Mais Detalhes</a>
            </div>

            <div class="status">
                <button id="propertyStatusBtn" class="reserved-btn">
                    <span id="statusIcon">✔</span> <span id="statusText">{{ $property['property_status'] }}</span>
                </button>
            </div>
            <!-- Passando as reservas para o data-reservations -->
            <div class="reservationsData" data-reservations='@json($property['reservations'])'></div>
        </div>
    </div>
</div>

<!-- Script para ajustar o icone e côr do campo do estado da propriedade (Ocupado/Reservado/Disponivel)-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Seleciona todos os elementos com a classe 'reservationsData'
        let reservationElements = document.querySelectorAll('.reservationsData');

        reservationElements.forEach(function(reservationsData) {
            let reservations = JSON.parse(reservationsData.dataset.reservations);

            let statusBtn = reservationsData.closest('.property-card').querySelector('#propertyStatusBtn');
            let statusText = reservationsData.closest('.property-card').querySelector('#statusText');
            let statusIcon = reservationsData.closest('.property-card').querySelector('#statusIcon');

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
    });
</script>

<!-- codigo para mostrar alerta para confirmação de eliminar propriedade -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-property").forEach(button => {
            button.addEventListener("click", function () {
                let propertyId = this.getAttribute("data-id");
                let deleteUrl = "{{ route('hostProperty.delete', ['id' => '__ID__']) }}".replace('__ID__', propertyId);

                Swal.fire({
                    title: "Tem certeza que pretende remover esta propriedade?",
                    text: "Esta ação não pode ser desfeita!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sim, remover!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl; // Redireciona para a exclusão
                    }
                });
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
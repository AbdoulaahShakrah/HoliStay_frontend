<link rel="stylesheet" href="{{asset('pages/css/client/my-reservations.css')}}">
@extends('layouts.client-layout')

@section('title', 'Home - HOLISTAY')

@section('content')


<div class="container">
  <div class="reservations-count">
    <h3>
      {{$reservations[0]['client']['client_name']}} tem {{count($reservations)}} reservas
    </h3>
  </div>
    @foreach(array_reverse($reservations) as $reservation)
    <x-my-reservation-card :reservation="$reservation" />
    @endforeach
</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: "Sucesso!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        }).then(() => {
            // Limpa os dados de sucesso da sessão usando sessionStorage
            sessionStorage.removeItem('success-message');
        });
    });

    // Armazena a mensagem na sessionStorage para evitar que reapareça ao retroceder
    sessionStorage.setItem('success-message', "{{ session('success') }}");
</script>
@endif
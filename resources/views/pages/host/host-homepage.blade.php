<link rel="stylesheet" href="{{ asset('pages/css/host/host-homepage.css') }}">
@extends('layouts.host-layout')

@section('title', 'Host - HOLISTAY')

@section('content')

<div class="properties-section">
    <h2>As minhas propriedades</h2>

    @foreach(array_reverse($properties) as $property)
    <x-host-property-card :property="$property" />
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
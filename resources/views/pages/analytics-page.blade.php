<link rel="stylesheet" href="{{ asset('pages/css/host/host-homepage.css') }}">
@extends('layouts.host-layout')

@section('title', 'Host - HOLISTAY')

@section('content')
<div class="analytics-container">
    <div class="cards">
        <div class="card visualizacoes">
            <h5>Visualizações</h5>
            <h2>{{ $totalViews }}</h2>
        </div>
        <div class="card reservas">
            <h5>Reservas</h5>
            <h2>{{ $totalReservations }}</h2>
        </div>
        <div class="card faturacao">
            <h5>Faturação (€)</h5>
            <h2>{{ number_format($totalRevenue, 2, ',', '.') }}</h2>
        </div>
    </div>

    <div class="chart-container">
        <div class="chart">
            <h5>Total de reservas por propriedade</h5>
            <canvas id="reservationsChart"></canvas>
        </div>
        <div class="chart">
            <h5>Visualizações por propriedade</h5>
            <canvas id="viewsChart"></canvas>
        </div>
    </div>
</div>

<style>
    /* Contêiner geral da página */
    .analytics-container {
        display: flex;
        flex-direction: column; /* Cards e gráficos em coluna */
        align-items: center;
        justify-content: flex-start;
        gap: 20px;
        padding: 40px 20px;
        max-width: 1200px;
        margin: 0 auto;
        min-height: 100vh;
    }

    /* Cards (visualizações, reservas, faturação) */
    .cards {
        display: flex;
        gap: 20px;
        justify-content: center; /* Centraliza os cards */
        width: 100%;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    /* Estilo de cada card */
    .card {
        padding: 20px;
        border-radius: 15px;
        color: white;
        text-align: center;
        width: 100%;
        max-width: 300px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Sombra suave */
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Efeito de hover */
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    /* Efeito ao passar o mouse nos cards */
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3); /* Sombra mais forte */
    }

    /* Cores de fundo dos cards */
    .visualizacoes {
        background-color: #ffc107; /* Amarelo */
    }

    .reservas {
        background-color: #007bff; /* Azul */
    }

    .faturacao {
        background-color: #28a745; /* Verde */
    }

    /* Estilo dos gráficos */
    .chart-container {
        display: flex;
        gap: 40px; /* Espaço entre os gráficos */
        align-items: center; /* Centraliza os gráficos */
        width: 100%;
    }

    .chart {
        width: 100%;
        max-width: 800px; /* Largura máxima do gráfico */
        background-color: rgb(245, 245, 245); /* Cor de fundo suave */
        padding: 30px;
        border-radius: 15px;
        box-sizing: border-box;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Sombra suave */
    }

    /* Ajuste do layout em telas pequenas */
    @media (max-width: 768px) {
        .cards {
            flex-direction: column;
            align-items: center;
        }
        
        .card {
            max-width: 100%;
        }

        .chart {
            max-width: 100%;
        }
        .chart-container {
        display: flex;
        flex-direction: column;    }

    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Gráfico de Reservas
        const reservationsCtx = document.getElementById('reservationsChart').getContext('2d');
        new Chart(reservationsCtx, {
            type: 'doughnut',
            data: {
                labels: JSON.parse('{!! json_encode(array_keys($propertyReservations)) !!}'),
                datasets: [{
                    data: JSON.parse('{!! json_encode(array_values($propertyReservations)) !!}'),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966CC', '#FF7F50'], // Mais cores
                }]
            }
        });

        // Gráfico de Visualizações
        const viewsCtx = document.getElementById('viewsChart').getContext('2d');
        const propertyViews = {!! json_encode(array_column($properties, 'page_visits', 'property_name'), JSON_FORCE_OBJECT) !!};
        new Chart(viewsCtx, {
            type: 'bar', // Gráfico de barras
            data: {
                labels: Object.keys(propertyViews),
                datasets: [{
                    label: 'Visualizações',
                    data: Object.values(propertyViews),
                    backgroundColor: '#007bff', // Cor das barras
                    borderColor: '#007bff',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Começa o eixo Y em 0
                    }
                }
            }
        });
    });
</script>

@endsection
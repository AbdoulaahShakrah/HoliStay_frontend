<link rel="stylesheet" href="{{ asset('pages/css/client/payment-page.css') }}">
@extends('layouts.client-layout')

@section('title', 'Home - HOLISTAY')

@section('content')
<div class="payment-container">
    <div class="payment-header">
        <h2>Confirmar Pagamento</h2>
    </div>

    <div class="reservation-info">
        <h3>Sua Viagem</h3>
        <p>
            Check-in: <span>{{ request('check_in') }}</span> |
            Check-out: <span>{{ request('check_out') }}</span>
        </p>
    </div>

    <div class="payment-main">
        <div class="payment-form">
            <h3>Selecionar Método de Pagamento</h3>
            <p>Escolha o método e confirme o pagamento</p>
            <form action="{{ route('store.payment.reservation') }}" method="POST">
                @csrf
                <div class="payment-methods">
                    <label class="radio-label">
                        <input type="radio" id="credit" name="payment_method" value="credit" checked>
                        <span class="custom-radio"></span>
                        <div class="radio-text">
                            <span class="radio-title">Cartão de Crédito/Débito</span>
                            <span class="radio-desc">Pague com seu cartão.</span>
                        </div>
                    </label>

                    <label class="radio-label">
                        <input type="radio" id="paypal" name="payment_method" value="paypal">
                        <span class="custom-radio"></span>
                        <div class="radio-text">
                            <span class="radio-title">PayPal</span>
                            <span class="radio-desc">Utilize sua conta PayPal.</span>
                        </div>
                    </label>
                </div>

                <div class="card-details" id="card-details">
                    <div class="form-group">
                        <label for="card-holder-name">
                            Nome do Titular <span class="required">*</span>
                        </label>
                        <input type="text" id="card-holder-name" name="card_holder_name" placeholder="Nome completo" required>
                    </div>
                    <div class="form-group">
                        <label for="card-number">
                            Número do Cartão <span class="required">*</span>
                        </label>
                        <input type="text" id="card-number" name="card_number" placeholder="**** **** **** ****" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group half">
                            <label for="expiration-date">
                                Expira em <span class="required">*</span>
                            </label>
                            <input type="text" id="expiration-date" name="expiration_date" placeholder="MM/YY" required>
                        </div>
                        <div class="form-group half">
                            <label for="cvv">
                                CVV <span class="required">*</span>
                            </label>
                            <input type="text" id="cvv" name="cvv" placeholder="***" required>
                        </div>
                    </div>
                    <p><span class="required">*</span> (Campos obrigatórias)</p>
                </div>

                <!-- Inputs ocultos para persistência dos dados da reserva -->
                <input type="hidden" name="property_id" value="{{ request('property_id') }}">
                <input type="hidden" name="check_in" value="{{ request('check_in') }}">
                <input type="hidden" name="check_out" value="{{ request('check_out') }}">
                <input type="hidden" name="total_price" value="{{ request('total_price') }}">

                <div class="form-buttons">
                    <button type="button" class="btn cancel-btn">Cancelar</button>
                    <button type="submit" class="btn confirm-btn">Pagar e Confirmar Reserva</button>
                </div>
            </form>
        </div>

        <div class="payment-summary">
            <h3>Resumo do Pagamento</h3>
            <p class="price"><strong>{{ request('property_price') }}</strong> / noite</p>
            <p class="total-price">Total a Pagar: <span>{{ request('total_price') }}</span></p>
            <p class="info">(incluindo todas as taxas)</p>
        </div>
    </div>
</div>

@endsection

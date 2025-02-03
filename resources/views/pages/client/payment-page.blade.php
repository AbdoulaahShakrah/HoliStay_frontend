@extends('layouts.client-layout')

@section('title', 'Home - HOLISTAY')

@section('content')

<div class="payment-container">
    
    <h2 class="title"> - Confirmar Pagamento</h2>
    <br><br>
    <h3 class="section-title">A sua viagem</h3>
    <div class="reservation-details">
        <p class="dates">Check-in: <span>{{request('check_in')}}</span> | Check-out: <span>{{request('check_out')}}</span></p>
    </div>

    <div class="payment-section">
        <div class="payment-form">
            <h3 class="section-title">Selecionar o método de pagamento</h3>
            <p>Escolha o método e confirme o pagamento</p>

            <form action="{{ route('store.payment.reservation') }}" method="POST" >
                @csrf
                <div class="payment-method">
                    <label class="radio-container">
                        <input type="radio" id="credit" name="payment_method" value="credit" checked>
                        <span class="custom-radio"></span>
                        <span class="radio-label">Cartão de crédito ou débito</span>
                        <span class="radio-desc">Use um cartão de crédito ou débito para realizar o pagamento.</span>
                    </label>

                    <label class="radio-container">
                        <input type="radio" id="paypal" name="payment_method" value="paypal">
                        <span class="custom-radio"></span>
                        <span class="radio-label">PayPal</span>
                        <span class="radio-desc">Use uma conta PayPal para realizar o pagamento.</span>
                    </label>
                </div>

                <div class="payment-details" id="card-details">
                    <label for="card-holder-name">Nome do titular</label>
                    <input class="payment-input" type="text" id="card-holder-name" name="card_holder_name" placeholder="Nome completo">

                    <label for="card-number">Número do cartão</label>
                    <input class="payment-input" type="text" id="card-number" name="card_number" placeholder="**** **** **** ****">

                    <div class="card-info">
                        <div>
                            <label for="expiration-date">Expira em</label>
                            <input class="payment-input" type="text" id="expiration-date" name="expiration_date" placeholder="MM/YY">
                        </div>
                        <div>
                            <label for="cvv">CVV</label>
                            <input class="payment-input" type="text" id="cvv" name="cvv" placeholder="***">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="property_id" value="{{request('property_id')}}">
                <input type="hidden" name="check_in" value="{{request('check_in')}}">
                <input type="hidden" name="check_out" value="{{request('check_out')}}">
                <input type="hidden" name="total_price" value="{{request('total_price')}}">

                <div class="button-group">
                    <button type="button" class="cancel-btn">Cancelar</button>
                    <button type="submit" class="confirm-btn">Pagar e confirmar reserva</button>
                </div>
            </form>
        </div>

        <div class="payment-summary">
            <h3>Dados de pagamento</h3>
            <p class="price"><strong>{{request('property_price')}}</strong> / noite</p>
            <p> O que vai pagar <span>{{request('total_price')}}</span> (com taxa incluida)</p>
        </div>
    </div>
</div>

<style>
    .payment-container {
        margin: auto;
        padding: 20px;
    }

    .title {
        font-size: 24px;
        font-weight: bold;
    }

    .section-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .reservation-details {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        text-align: center;
    }

    .reservation-details .dates{
        font-size: 18px;
        color:indianred
        
    }

    .payment-section {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .payment-form {
        flex: 1;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .payment-method {
        margin-bottom: 15px;
    }

    .radio-container {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px;
        border: 2px solid #ccc;
        border-radius: 10px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: 0.3s;
    }

    .radio-container:hover {
        border-color: #ff6a00;
    }

    .radio-container input {
        display: none;
    }

    .custom-radio {
        width: 20px;
        height: 20px;
        border: 2px solid #999;
        border-radius: 50%;
        display: inline-block;
        position: relative;
    }

    .radio-container input:checked+.custom-radio {
        border-color: #ff6a00;
        background: #ff6a00;
    }

    .radio-container input:checked+.custom-radio::after {
        content: "";
        width: 10px;
        height: 10px;
        background: white;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
    }

    .radio-label {
        font-weight: bold;
        font-size: 16px;
    }

    .radio-desc {
        font-size: 14px;
        color: #666;
    }

    .payment-details {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .card-info {
        display: flex;
        gap: 10px;
    }

    .payment-input {
        width: 100%;
        padding: 8px;
        margin: 5px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .button-group {
        display: flex;
        gap: 10px;
    }

    .cancel-btn {
        background: #ccc;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .confirm-btn {
        background: #ff833c;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .payment-summary {
        background: #fff6e6;
        padding: 20px;
        border-radius: 8px;
        width: 300px;
        height: fit-content;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .payment-summary h3 {
        color: #d87d00;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .payment-summary p {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .payment-summary .price {
        font-size: 20px;
        color: #ff6a00;
    }

    @media screen and (max-width: 1020px) {
        .payment-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }
    }
</style>

@endsection
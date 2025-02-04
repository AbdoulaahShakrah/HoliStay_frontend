<link rel="stylesheet" href="{{asset('pages/css/client/my-reservations.css')}}">
@extends('layouts.client-layout')

@section('title', 'Home - HOLISTAY')

@section('content')
<style>
.toast {
  position: absolute;
  top: 175px;
  right: 30px;
  border-radius: 12px;
  background: #fff;
  padding: 20px 35px 20px 25px;
  box-shadow: 0 6px 20px -5px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transform: translateX(calc(100% + 30px));
  transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.35);
}

.toast.active {
  transform: translateX(0%);
}

.toast .toast-content {
  display: flex;
  align-items: center;
}

.toast-content .check {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 35px;
  min-width: 35px;
  background-color: #4070f4;
  color: #fff;
  font-size: 20px;
  border-radius: 50%;
}

.toast-content .message {
  display: flex;
  flex-direction: column;
  margin: 0 20px;
}

.message .text {
  font-size: 16px;
  font-weight: 400;
  color: #666666;
}

.message .text.text-1 {
  font-weight: 600;
  color: #333;
}
</style>

@if(session('success'))
<div class="toast active" id="toast">
    <div class="toast-content">
        <i class="fas fa-solid fa-check check"></i>

        <div class="message">
            <span class="text text-1">Success</span>
            <span class="text text-2">{{ session('success') }}</span>
        </div>
    </div>
</div>

<script>
    setTimeout(() => {
        let toast = document.getElementById('toast');
        if (toast) {
            toast.classList.remove('active'); 
        }
    }, 5000);
</script>
@endif

<div class="container">
    @foreach($reservations as $reservation)
    <x-my-reservation-card :reservation="$reservation" />
    @endforeach
</div>

@endsection

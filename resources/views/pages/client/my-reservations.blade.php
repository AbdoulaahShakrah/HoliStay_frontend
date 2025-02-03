<link rel="stylesheet" href="{{asset('pages/css/client/my-reservations.css')}}">
@extends('layouts.client-layout')

@section('title', 'Home - HOLISTAY')

@section('content')

<div class="container">

    @foreach($reservations as $reservation)
    <x-my-reservation-card :reservation="$reservation"/>
    @endforeach
</div>

@endsection
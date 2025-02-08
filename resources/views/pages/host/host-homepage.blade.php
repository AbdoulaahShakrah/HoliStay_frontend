<link rel="stylesheet" href="{{ asset('pages/css/host/host-homepage.css') }}">
@extends('layouts.host-layout')

@section('title', 'Host - HOLISTAY')

@section('content')

<div class="properties-section">
    <h2>As minhas propriedades</h2>

    @foreach(array_reverse($properties) as $property)
        <x-host-property-card :property="$property"/>
    @endforeach

</div>
@endsection
<link rel="stylesheet" href="{{ asset('components/css/property-slider.css') }}">
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

<div class="slider-wrapper" id="sliderWrapper">
    <button id="prev-slide" class="slide-button material-symbols-rounded">chevron_left</button>
    <div class="image-list" id="imageList">
        <!--<img *ngFor="let image of selectedProperty?.images; let i = index" [src]="image" class="image-item"
                [alt]="'img-' + i">-->
        <img class="image-item" src="{{ asset('images/homepage/1.webp') }}">
        <img class="image-item" src="{{ asset('images/homepage/1.webp') }}">
        <img class="image-item" src="{{ asset('images/homepage/1.webp') }}">
        <img class="image-item" src="{{ asset('images/homepage/1.webp') }}">
        <img class="image-item" src="{{ asset('images/homepage/1.webp') }}">
        <img class="image-item" src="{{ asset('images/homepage/1.webp') }}">
        <img class="image-item" src="{{ asset('images/homepage/1.webp') }}">
    </div>


    <button id="next-slide"
        class="slide-button material-symbols-rounded">chevron_right</button>
</div>
<script src="{{ asset('components/js/property-slider.js') }}"></script>
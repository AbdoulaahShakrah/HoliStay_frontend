<link rel="stylesheet" href="{{ asset('components/css/datera.min.css') }}">
<link rel="stylesheet" href="{{ asset('components/css/search-bar.css') }}">
<div class="searchbar">

    <form id="searchbar-form" method="POST" action="{{ route('search') }}">
        @csrf

        <div class="search-inputs">

            <div class="input-box">
                <input type="text" name="location" id="location" placeholder="Ex: Lisboa" value="{{ session('location') }}" required />
                <i class="fa fa-map-marker-alt"></i>
            </div>

            <div class="input-box">
                <input class="datepicker" name="dates" id="dates" placeholder="Check-in --> Check-out" value="{{ session('dates', old('dates')) }}" required />
                <i class="fa fa-calendar"></i>
            </div>

            <div class="input-box">
                <input type="text" name="guests" id="guests" placeholder="Hóspedes" value="{{ session('guests') }}" required />
                <i class="fa fa-user"></i>
                <div class="guest-dropdown" id="guest-dropdown">
                    <div class="guest-option">
                        <span>Adultos</span>
                        <div class="counter">
                            <button type="button" class="decrement">-</button>
                            <span class="count">0</span>
                            <button type="button" class="increment">+</button>
                        </div>
                    </div>

                    <div class="guest-option">
                        <span>Crianças</span>
                        <div class="counter">
                            <button type="button" class="decrement">-</button>
                            <span class="count">0</span>
                            <button type="button" class="increment">+</button>
                        </div>

                    </div>

                    <div class="guest-option">
                        <span>Bebés</span>
                        <div class="counter">
                            <button type="button" class="decrement">-</button>
                            <span class="count">0</span>
                            <button type="button" class="increment">+</button>
                        </div>
                    </div>

                </div>
            </div>

            <button type="submit" class="search-btn" id="search-btn">
                <i class="fa fa-search"></i>
            </button>

        </div>
    </form>
</div>



<!-- Categorias -->
<div class="search-categories">
    <button>
        <i class="fa fa-umbrella-beach"></i> Beachfront
    </button>
    <button>
        <i class="fa fa-home"></i> Cabins
    </button>
    <button>
        <i class="fa fa-skiing"></i> Skiing
    </button>
    <button>
        <i class="fa fa-piano"></i> Grand Pianos
    </button>
    <button>
        <i class="fa fa-building"></i> Mansions
    </button>
    <button>
        <i class="fa fa-bolt"></i> OMG!
    </button>
    <button>
        <i class="fa fa-swimmer"></i> Amazing Pools
    </button>
</div>

<script src="{{ asset('components/js/search-bar.js') }}"></script>
<script src="{{ asset('components/js/guests.js') }}"></script>
<script src="{{ asset('components/js/datera.min.js') }}"></script>
<!--
<script>
    new window.Datera("datepicker", {
      minYear: 2000,
      selectionType: "range",
    }).mount();
  </script>
  -->
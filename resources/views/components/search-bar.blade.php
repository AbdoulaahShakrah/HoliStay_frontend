<link rel="stylesheet" href="{{ asset('components/css/datera.min.css') }}">
<link rel="stylesheet" href="{{ asset('components/css/search-bar.css') }}">
<form id="searchbar-form" method="POST" action="{{ route('generalSearch') }}">

    <div class="searchbar">

        @csrf

        <div class="search-inputs">

            <div class="input-box">
                <input type="text" name="location" id="location" placeholder="Ex: Lisboa"
                    value="{{ is_array(request('propertyCity')) ? implode(', ', request('propertyCity')) : '' }}" required />
                <i class="fa fa-map-marker-alt"></i>
            </div>
            @php
            use Carbon\Carbon;

            // Obtenha as datas de check-in e check-out
            $checkInDate = request('checkInDate')['eq'] ?? '';
            $checkOutDate = request('checkOutDate')['eq'] ?? '';

            // Verifique se as datas não estão vazias
            if ($checkInDate && $checkOutDate) {

            $checkIn = Carbon::parse($checkInDate);
            $checkOut = Carbon::parse($checkOutDate);
            $difference = $checkIn->diffInDays($checkOut);
            session()->put('difference', $difference);
            } else {
            $difference = 0;
            }
            @endphp

            <div class="input-box">
                <input class="datepicker" name="dates" id="dates"
                    placeholder="Check-in --> Check-out"
                    value="{{ $checkInDate && $checkOutDate ? $checkInDate . ' - ' . $checkOutDate : '' }}"

                    required />
                <i class="fa fa-calendar"></i>
            </div>


            <div class="input-box">
                <input type="text" name="guests" id="guests" autocomplete="off" placeholder="Hóspedes" value="{{ is_array(request('propertyCapacity')) ? implode(', ', request('propertyCapacity')) : '' }}" required />
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
    </div>
</form>

<div class="search-categories">
    @foreach(session('categories') as $category)
    <form action="{{route('catagorySearch')}}" method="POST">
        @csrf <!-- Token de segurança obrigatório para POST -->

        <input type="hidden" name="category" value="{{$category}}">
        <button type="submit">
            <i class="fa fa-{{$category}}"></i> {{$category}}
        </button>
    </form>

    @endforeach
</div>

<script src="{{ asset('components/js/search-bar.js') }}"></script>
<script src="{{ asset('components/js/guests.js') }}"></script>
<script src="{{ asset('components/js/datera.min.js') }}"></script>

<script>
    new window.Datera("datepicker", {
      minYear: 2000,
      selectionType: "range",
    }).mount();
  </script>
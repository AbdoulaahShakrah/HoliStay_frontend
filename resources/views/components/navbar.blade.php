<link rel="stylesheet" href="{{ asset('components/css/navbar.css') }}">

<header class="header">
    <div class="left-side">
        <a href="/home" class="holistay_logo">
            <img src="{{ asset('/images/holistay_logo.png') }}" alt="HoliStay Logo" />
        </a>
    </div>
    <div class="right-side">
        <button type="button">
            <a href="#">Anuncie a sua propriedade</a>
        </button>

        @if(session('access_token'))
        @if(session('role') == 'client')
        <a href="/reservas">
            <i class="fa fa-calendar-check"></i>
            <span>Minhas Reservas</span>
        </a>
        @elseif(session('role') == 'host')
        <a href="/hostProperties">
            <i class="fa fa-home"></i>
            <span>Minhas Propriedades</span>
        </a>
        <a href="/my-reservations">
            <i class="fa fa-calendar-check"></i>
            <span>Minhas Reservas</span>

        </a>
        @endif
        <!-- Logout -->
        <a href="/logout">
            <i class="fa fa-sign-out"></i>
            <span>Log out</span>
        </a>
        @else
        <a href="/login">
            <i class="fa fa-sign-in"></i>
            <span>Login</span>
        </a>
        @endif
    </div>
</header>
<link rel="stylesheet" href="{{ asset('components/css/admin-navbar.css') }}">

<header class="header">
    <div class="left-side">
        <a href="#" class="holistay_logo">
            <img src="{{ asset('/images/holistay_logo.png') }}" alt="HoliStay Logo" />
        </a>
    </div>
    <div class="right-side">
        <button type="button">
            <a href="#">Adicionar uma propriedade</a>
        </button>

        <!-- Logout -->
        <a href="/logout">
            <i class="fa fa-sign-out"></i>
            <span>Log out</span>
        </a>
    </div>
</header>
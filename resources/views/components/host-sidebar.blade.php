<link rel="stylesheet" href="{{ asset('components/css/host-sidebar.css') }}">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Botão de Menu Hamburger -->
<div class="hamburger" onclick="toggleMenu()">
    <i class="fas fa-bars"></i>
</div>

<!-- Sidebar -->
<div class="menu" id="sidebar">
    <ul>
        <li class="profile">
            <div class="img_box">
                <i class="fas fa-user"></i>
            </div>
            <h2>{{ session('hostName')}}</h2>
        </li>
        <li>
            <a href="{{ route('hostProperties') }}" class="side-bar-a">
                <i class="fas fa-home"></i>
                <p>Propriedades</p>
            </a>
        </li>
        <li>
            <a href="{{ route('setAnalyticsPage') }}" class="side-bar-a">
                <i class="fas fa-chart-pie"></i>
                <p>Análises</p>
            </a>
        </li>
        <li>
            <a href="#" class="side-bar-a">
                <i class="fas fa-comment-alt"></i>
                <p>Mensagens</p>
            </a>
        </li>
        <li class="log-out">
            <a href="/logout" class="side-bar-a">
                <i class="fas fa-sign-out-alt"></i>
                <p>Sair</p>
            </a>
        </li>
    </ul>
</div>

<script>
    function toggleMenu() {
        document.getElementById("sidebar").classList.toggle("active");
    }
</script>

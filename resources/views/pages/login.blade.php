<link rel="stylesheet" href="{{ asset('pages/css/login.css') }}">

<form action="{{ route('login.confirmation') }}" method="POST" class="input-box">
    @csrf
    <input type="text" name="email" class="input-field" placeholder="Email" autocomplete="on" required>
    <input type="password" name="password" class="input-field" placeholder="Password" autocomplete="off" required>
    <button class="submit-btn" type="submit">Login</button>
</form>

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

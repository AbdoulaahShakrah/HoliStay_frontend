<link rel="stylesheet" href="{{ asset('pages/css/login.css') }}">
<div class="container">
    <div class="login-box">
        <a class="homePage-back" href="/home"> 
            <p>Pesquisa uma propriedade</p> </a>
        <form action="{{ route('login.confirmation') }}" method="POST" class="input-box">
            @csrf
            <div class="input-box">
                <input type="text" name="email" class="input-field" placeholder="Email" autocomplete="on" required>
            </div>
            <div class="input-box">
                <input type="password" name="password"  class="input-field" placeholder="Password" autocomplete="off" required>
            </div>
            <div class="forgot">
                <section>
                    <a href="#">Forgot password?</a>
                </section>
            </div>
            <div class="input-submit">
                <button class="submit-btn" id="submit" type="submit"></button>
                <label for="submit">Sign In</label>
            </div>
        </form>
        @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
        @endif


        <div class="terms-conditions">
            <p>
                By creating an account, you agree
            </p>
            <p>
                to our <a>Terms and conditions </a>
            </p>
            <p>
                and with the <a>Declaration of Privacy.</a>
            </p>

        </div>
    </div>
</div>
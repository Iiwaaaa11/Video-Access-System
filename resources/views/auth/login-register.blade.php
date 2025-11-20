<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register</title>
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="container" id="container">
        <!-- Daftar Form (Sign In & Sign Up) -->
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Form Sign In -->
                <form action="{{ route('login') }}" method="POST" class="sign-in-form">
                    @csrf
                    <h2 class="title">Sign in</h2>
                    @error('email')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus />
                    </div>
                    @error('password')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" required />
                    </div>
                    <a href="{{ route('password.request') }}" class="social-text">Forgot your password?</a>
                    <input type="submit" value="Login" class="btn solid" />
                </form>
                <!-- Form Sign Up -->
                <form action="{{ route('register') }}" method="POST" class="sign-up-form">
                    @csrf
                    <h2 class="title">Sign up</h2>
                    @error('name')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Name" name="name" value="{{ old('name') }}" required />
                    </div>
                    @error('email')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" required />
                    </div>
                    @error('password')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" required />
                    </div>
                    <input type="submit" class="btn" value="Sign up" />
                </form>
            </div>
        </div>

        <!-- Panel Geser (Overlay) -->
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here ?</h3>
                    <p>Belum memiliki akun? Daftar sekarang untuk mengakses seluruh koleksi video kami dan nikmati pengalaman menonton yang tak terbatas. </p>
                    <button class="btn transparent" id="sign-up-btn">Sign up</button>
                </div>
                <img src="https://i.ibb.co/6HXL6q1/Privacy-policy-pana.svg" class="image" alt="">
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Have account?</h3>
                    <p>Sudah memiliki akun? Masuk sekarang untuk melanjutkan perjalanan menonton Anda dan akses koleksi video pribadi yang sudah Anda simpan.</p>
                    <button class="btn transparent" id="sign-in-btn">Sign in</button>
                </div>
                <img src="https://i.ibb.co/nP8H853/Mobile-login-pana.svg" class="image" alt="">
            </div>
        </div>
    </div>

    <script src="{{ asset('js/login-register.js') }}"></script>
</body>
</html>

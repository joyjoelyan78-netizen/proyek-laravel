<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin VESCA</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>

<body>

<div class="login-container">

    <div class="login-box">

        <div class="login-header">
            <h1>VESCA</h1>
            <p>Admin Panel Login</p>
        </div>

        <!-- ERROR -->
        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- EMAIL -->
            <div class="input-group">
                <label>Email</label>

                <div class="input-icon">
                    <i class="ri-mail-line"></i>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        required
                    >
                </div>
            </div>

            <!-- PASSWORD -->
            <div class="input-group">
                <label>Password</label>

                <div class="input-icon">
                    <i class="ri-lock-line"></i>

                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                </div>
            </div>

            <!-- REMEMBER -->
            <div class="remember">
                <label>
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn-login">
                <i class="ri-login-box-line"></i>
                Login
            </button>

        </form>

    </div>

</div>

</body>
</html>
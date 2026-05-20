<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión — Task Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sora', sans-serif;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .bg-image {
            position: fixed;
            inset: 0;
            background-image: url('/imgs/main.jpg');
            background-size: cover;
            background-position: center;
            z-index: 0;
        }

        .bg-overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, rgba(10, 20, 60, 0.72) 0%, rgba(5, 30, 80, 0.55) 50%, rgba(10, 20, 60, 0.72) 100%);
            backdrop-filter: blur(1px);
            z-index: 1;
        }

        .page {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav {
            padding: 1.25rem 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(12px);
        }

        .nav-brand {
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-brand-icon {
            width: 30px;
            height: 30px;
            background: rgba(59, 130, 246, 0.5);
            border-radius: 7px;
            border: 1px solid rgba(147, 197, 253, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        .btn-nav-ghost {
            padding: 0.45rem 1.1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            font-family: 'Sora', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.8);
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .btn-nav-ghost:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.09);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.18);
        }

        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .avatar-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.2);
            border: 1px solid rgba(147, 197, 253, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }

        .avatar-circle svg {
            width: 26px;
            height: 26px;
            color: #93c5fd;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.35rem;
        }

        .card-subtitle {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.45);
            font-weight: 300;
        }

        /* Session status */
        .session-status {
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(147, 197, 253, 0.25);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.8rem;
            color: #93c5fd;
            margin-bottom: 1.25rem;
            display: none;
        }

        .session-status.visible {
            display: block;
        }

        /* Form */
        .field {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-size: 0.78rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.55);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            width: 16px;
            height: 16px;
            color: rgba(255, 255, 255, 0.35);
            pointer-events: none;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-family: 'Sora', sans-serif;
            font-weight: 400;
            color: #fff;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.2s;
            outline: none;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        input:focus {
            background: rgba(255, 255, 255, 0.11);
            border-color: rgba(147, 197, 253, 0.5);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.3);
            padding: 0;
            transition: color 0.2s;
            display: flex;
        }

        .toggle-password:hover {
            color: rgba(255, 255, 255, 0.6);
        }

        .toggle-password svg {
            width: 16px;
            height: 16px;
        }

        .field-error {
            font-size: 0.75rem;
            color: #fca5a5;
            margin-top: 0.4rem;
        }

        /* Remember + forgot */
        .row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            accent-color: #3b82f6;
            cursor: pointer;
        }

        .checkbox-text {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.55);
            font-weight: 400;
            text-transform: none;
            letter-spacing: 0;
        }

        .link-forgot {
            font-size: 0.82rem;
            color: #60a5fa;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .link-forgot:hover {
            color: #93c5fd;
        }

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Sora', sans-serif;
            cursor: pointer;
            border: 1px solid rgba(147, 197, 253, 0.4);
            color: #fff;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.35);
            transition: all 0.25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(59, 130, 246, 0.5);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .arrow {
            transition: transform 0.2s;
        }

        .btn-submit:hover .arrow {
            transform: translateX(3px);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.25rem 0;
            color: rgba(255, 255, 255, 0.2);
            font-size: 0.75rem;
            letter-spacing: 0.08em;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }

        .register-row {
            text-align: center;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .register-row a {
            color: #60a5fa;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .register-row a:hover {
            color: #93c5fd;
        }
    </style>
</head>

<body>
    <div class="bg-image"></div>
    <div class="bg-overlay"></div>

    <div class="page">
        <nav>
            <a href="{{ route('home') }}" class="nav-brand">
                <div class="nav-brand-icon">✓</div>
                TASK MANAGER
            </a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-nav-ghost">Crear cuenta</a>
            @endif
        </nav>

        <div class="main">
            <div class="glass-card">
                <div class="card-header">
                    <div class="avatar-circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                    <h1 class="card-title">Bienvenido de nuevo</h1>
                    <p class="card-subtitle">Inicia sesión para continuar</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field">
                        <label for="email">Email</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                placeholder="seu@email.com" required autofocus autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="field-error" />
                    </div>

                    <div class="field">
                        <label for="password">Contraseña</label>
                        <div class="input-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0110 0v4" />
                            </svg>
                            <input id="password" type="password" name="password" placeholder="••••••••" required
                                autocomplete="current-password" />
                            <button type="button" class="toggle-password" onclick="togglePass()"
                                aria-label="Ver contraseña">
                                <svg id="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="field-error" />
                    </div>

                    <div class="row-between">
                        <label class="checkbox-label">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span class="checkbox-text">Recuérdame</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link-forgot">
                                ¿Olvidaste la contraseña?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn-submit">
                        Iniciar sesión <span class="arrow">→</span>
                    </button>

                    <div class="divider">ou</div>

                    <div class="register-row">
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}">Crear ahora</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePass() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML =
                    '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
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
            background-repeat: no-repeat;
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

        /* Navbar */
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
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-brand-icon {
            width: 32px;
            height: 32px;
            background: rgba(59, 130, 246, 0.5);
            border-radius: 8px;
            border: 1px solid rgba(147, 197, 253, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .nav-links {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .btn-nav-ghost {
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 500;
            font-family: 'Sora', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.85);
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-nav-ghost:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.35);
            color: #fff;
        }

        .btn-nav-primary {
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            font-family: 'Sora', sans-serif;
            cursor: pointer;
            transition: all 0.25s ease;
            text-decoration: none;
            color: #fff;
            background: rgba(59, 130, 246, 0.65);
            border: 1px solid rgba(147, 197, 253, 0.5);
        }

        .btn-nav-primary:hover {
            background: rgba(59, 130, 246, 0.85);
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.35);
        }

        /* Hero */
        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
        }

        .hero-inner {
            max-width: 560px;
            width: 100%;
            text-align: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.35rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            color: rgba(147, 197, 253, 0.9);
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(147, 197, 253, 0.25);
            margin-bottom: 1.75rem;
            text-transform: uppercase;
        }

        .hero-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #60a5fa;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(0.8);
            }
        }

        h1 {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 700;
            color: #fff;
            line-height: 1.1;
            letter-spacing: -0.02em;
            margin-bottom: 1.25rem;
        }

        h1 span {
            color: #60a5fa;
        }

        .hero-subtitle {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.7;
            margin-bottom: 2.5rem;
            font-weight: 300;
        }

        /* Glass card */
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 2.25rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.15);
        }

        .cta-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
        }

        .btn-primary {
            width: 100%;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Sora', sans-serif;
            cursor: pointer;
            transition: all 0.25s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #fff;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: 1px solid rgba(147, 197, 253, 0.4);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.35);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(59, 130, 246, 0.5);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            width: 100%;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            font-family: 'Sora', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.75);
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.22);
            color: #fff;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 0.25rem 0;
            color: rgba(255, 255, 255, 0.25);
            font-size: 0.75rem;
            letter-spacing: 0.08em;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.12);
        }

        /* Features strip */
        .features {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.45);
            font-weight: 400;
        }

        .feature-item svg {
            width: 14px;
            height: 14px;
            color: #60a5fa;
            opacity: 0.8;
        }

        /* Arrow icon */
        .arrow-icon {
            font-size: 1rem;
            transition: transform 0.2s;
        }

        .btn-primary:hover .arrow-icon {
            transform: translateX(3px);
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
            <div class="nav-links">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-nav-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-nav-ghost">Iniciar sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-nav-primary">Crear cuenta</a>
                    @endif
                @endauth
            </div>
        </nav>

        <div class="hero">
            <div class="hero-inner">
                <div class="hero-badge">
                    <div class="hero-badge-dot"></div>
                    Organiza tus tareas
                </div>
                <h1>Gestiona todo<br>con <span>claridad</span></h1>

                <p class="hero-subtitle">
                    Crea, organiza y sigue tus tareas de forma simple y eficiente.
                </p>

                <div class="glass-card">
                    <div class="cta-buttons">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-primary">
                                Ir al panel
                                <span class="arrow-icon">→</span>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-primary">
                                Comenzar ahora
                                <span class="arrow-icon">→</span>
                            </a>
                            <div class="divider">o</div>
                            <a href="{{ route('login') }}" class="btn-secondary">
                                Ya tengo una cuenta
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="features">
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        Categorías
                    </div>
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        Imágenes en las tareas
                    </div>
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        Acceso seguro
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

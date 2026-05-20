<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Sora', sans-serif;
            min-height: 100vh;
            background-color: #dbeafe;
            background-image:
                radial-gradient(circle, #93c5fd 1.5px, transparent 1.5px);
            background-size: 28px 28px;
            position: relative;
        }

        body {
            background:
                linear-gradient(#ffffff8a, rgb(147 147 147 / 70%)),
                url(http://localhost:8001/imgs/main.jpg) center / cover no-repeat fixed;
            margin: 0;
            min-height: 100vh;
            backdrop-filter: blur(3px);
        }

        .app-wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 2rem 1.5rem;
        }

        .app-card {
            width: 100%;
            max-width: 1200px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            border: 1px solid rgba(147, 197, 253, 0.3);
            box-shadow:
                0 4px 6px rgba(59, 130, 246, 0.05),
                0 20px 60px rgba(59, 130, 246, 0.1),
                0 1px 0 rgba(255, 255, 255, 0.8) inset;
            overflow: hidden;
            min-height: 80vh;
        }
    </style>
</head>

<body>
    <div class="app-wrapper">
        <div class="app-card">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-b border-gray-100">
                    <div class="max-w-7xl mx-auto py-5 px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>

# Task Manager

Aplicación web de gestión de tareas personales construida con Laravel 11 + Breeze.

## Stack

- **Backend:** Laravel 11, PHP 8.x
- **Frontend:** Blade + Tailwind CSS + Vite
- **Auth:** Laravel Breeze
- **Base de datos:** MySQL / SQLite

## Instalación

```bash
git clone <repo>
cd task-manager

composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate
npm run dev
php artisan serve
```

## Estructura de vistas

```
resources/views/
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   └── ...
├── layouts/
│   ├── app.blade.php       # Layout principal (fondo imgs/main.jpg + card blanca)
│   ├── guest.blade.php     # Layout para auth (fondo imgs/main.jpg + glassmorphism)
│   └── navigation.blade.php
├── tasks/
│   └── index.blade.php
└── welcome.blade.php       # Landing page pública
```

## Imágenes requeridas

```
public/imgs/main.jpg    # Imagen de fondo principal (login, register, app layout)
```

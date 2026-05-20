# CHANGELOG.md

Historial de cambios del proyecto.

## [Unreleased]

### Added
- Estética glassmorphism en todas las vistas de auth y layout principal
- Landing page pública (`welcome.blade.php`) con CTA
- Redirección post-login directo a `tasks.index` (sin pasar por dashboard vacío)
- Imagen de fondo `imgs/main.jpg` en login, register y layout app
- Fuente Sora en vistas de autenticación y layout

### Changed
- `login.blade.php` — rediseño completo con glassmorphism, toggle de contraseña, íconos en inputs
- `register.blade.php` — rediseño consistente con login
- `app.blade.php` — nuevo layout con fondo de imagen y card blanca centrada
- `dashboard` route — ahora redirige a `tasks.index`

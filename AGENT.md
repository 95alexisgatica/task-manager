# AGENTS.md

Instrucciones para agentes IA que trabajen en este proyecto.

## Contexto del proyecto

Task Manager es una app Laravel 11 con autenticación Breeze. Permite a usuarios crear tareas con categorías, fechas límite e imágenes adjuntas.

## Stack y convenciones

- **Framework:** Laravel 11 — respetar convenciones de nombres (snake_case en DB, camelCase en PHP, kebab-case en rutas)
- **Vistas:** Blade con componentes (`x-primary-button`, `x-input-label`, `x-text-input`, `x-input-error`)
- **Estilos:** Tailwind CSS — no escribir CSS custom salvo en los layouts principales
- **Auth:** Laravel Breeze — no modificar la lógica de autenticación, solo las vistas

## Diseño visual

El proyecto usa una estética **glassmorphism** consistente en todas las vistas:

- **Fondo:** `public/imgs/main.jpg` fijo con `background-attachment: fixed`
- **Cards:** `background: rgba(255,255,255, 0.9)`, `border-radius: 20px`, `box-shadow` suave
- **Botones primarios:** gradiente azul `#3b82f6 → #2563eb`
- **Fuente:** Sora (Google Fonts)
- **Inputs:** fondo semitransparente con borde sutil, ícono SVG a la izquierda

## Rutas disponibles

```
GET  /                    → welcome (pública)
GET  /dashboard           → redirige a tasks.index
GET  /tasks               → tasks.index (lista de tareas)
POST /tasks               → tasks.store
PUT  /tasks/{task}        → tasks.update
DELETE /tasks/{task}      → tasks.destroy
POST /categories          → categories.store
PATCH /categories/{id}    → categories.update
DELETE /categories/{id}   → categories.destroy
POST /tasks/{task}/images → task-images.store
PATCH /images/{image}/cover → task-images.cover
DELETE /images/{image}    → task-images.destroy
```

## Modelos principales

- `User` — autenticación estándar Breeze
- `Task` — pertenece a `User`, tiene `title`, `description`, `status`, `due_date`
- `Category` — pertenece a `User`, agrupa tareas
- `TaskImage` — pertenece a `Task`, puede ser imagen de portada (`is_cover`)

## Reglas para modificaciones

1. **No romper la autenticación** — no tocar `app/Http/Controllers/Auth/`
2. **Mantener la estética glassmorphism** en cualquier vista nueva
3. **Usar componentes Blade existentes** antes de crear HTML crudo
4. **Las rutas protegidas** deben tener el middleware `auth`
5. **Imágenes** se guardan en `storage/app/public` y se acceden via `Storage::url()`

## Lo que NO hacer

- No instalar paquetes nuevos sin indicarlo en CHANGELOG.md
- No cambiar migraciones existentes, crear nuevas migraciones
- No modificar `public/imgs/main.jpg` (imagen de fondo principal)

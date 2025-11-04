# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

Project overview
- Hybrid PHP codebase:
  - Custom OOP MVC app (runtime) under `app/Controllers`, `app/Models`, `app/Views`, `app/Core` with front controller at `public/index.php` and routes in `app/routes.php`.
  - A Laravel 12 skeleton (tooling/tests/assets) with `artisan`, `routes/web.php`, `resources/`, and Vite.

Common commands
- Install deps
  - PHP: `composer install`
  - Node: `npm install`
- Env (for Laravel tooling/tests)
  - `copy .env.example .env` (Windows) then `php artisan key:generate`
- Dev servers
  - Custom MVC via Apache (recommended): point DocumentRoot to `public/` (e.g., XAMPP). Entry: `http://localhost/<project>/public`.
  - Quick local server: `php -S localhost:8080 -t public`
  - Laravel tooling dev loop (optional): `composer run dev` (runs `php artisan serve`, queue listener, pail, and `npm run dev` via `concurrently`).
- Build assets (Vite)
  - Dev: `npm run dev`
  - Prod build: `npm run build`
- Tests (Laravel PHPUnit)
  - All tests: `composer test` or `php artisan test`
  - Single test by name: `php artisan test --filter <TestMethodOrClass>`
  - Single file: `php artisan test tests/Feature/ExampleTest.php --filter <method>`
- Lint/format (PHP)
  - Check only: `vendor\bin\pint --test`
  - Auto-fix: `vendor\bin\pint`

Setup notes (database/app)
- Custom MVC uses MySQL configured in `config/config.php`. Import `database/forumhub_mvc.sql` (and optionally `database/sample_data.sql`).
- URL rewriting is enabled via `public/.htaccess` (use Apache or ensure equivalent routing when using a built-in server).
- Laravel’s `.env` is only required for Laravel tooling/tests; the runtime app reads `config/config.php`.

Architecture and structure
- Runtime (Custom MVC)
  - Entry: `public/index.php` bootstraps config, registers a simple class autoloader mapping namespaces (`Core`, `Controllers`, `Models`) to `app/` and dispatches the router.
  - Routing: `app/routes.php` registers routes against `Core\Router` using callables like `['Controllers\\ThreadController', 'index']`.
  - Controllers: `app/Controllers/*` extend `Core\Controller` and render views via `$this->view(...)`.
  - Models: `app/Models/*` extend `Core\Model` and use `Core\Database` (PDO) with prepared statements; table names are defined per model.
  - Views: `app/Views/*` (PHP templates) organized by feature with shared layouts in `app/Views/layouts/`.
  - Assets: static assets under `public/assets/` used by the MVC views.
- Laravel scaffold (tooling/tests/assets)
  - `artisan` CLI, config in `config/*.php`, default route in `routes/web.php`, views in `resources/views`, Vite inputs in `resources/css` and `resources/js` with `vite.config.js`.
  - PHPUnit config (`phpunit.xml`) runs tests with an in-memory SQLite database and sensible defaults for queues/cache/session.

Conventions and gotchas
- Two routers: update `app/routes.php` for the custom MVC; `routes/web.php` affects only the Laravel skeleton.
- Composer autoload (`composer.json`) is set for `App\` (Laravel). Custom MVC classes under `Core`, `Controllers`, and `Models` are autoloaded by the front controller, not Composer. Don’t rely on Composer autoload for them in CLI contexts unless you include the MVC bootstrap.
- The Composer `setup` script includes `artisan migrate`; this repo does not include Laravel migrations, so that step may be a no-op or fail—prefer manual SQL import for the MVC app.
- Tests use `phpunit.xml` with in-memory SQLite; they won’t affect your MySQL data.

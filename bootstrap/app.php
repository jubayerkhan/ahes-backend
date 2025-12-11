<?php

use App\Exceptions\Handler;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\ForceLogoutMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    // web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
    using: function () {
      Route::middleware('web')
        ->group(base_path('routes/web.php'));

      Route::middleware('web')
        ->group(base_path('routes/admin.php'));

      // Route::middleware('api')
      //   ->prefix('api')
      //   ->group(base_path('routes/api.php'));
    },
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->group('web', [
      \Illuminate\Cookie\Middleware\EncryptCookies::class,
      \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
      \Illuminate\Session\Middleware\StartSession::class,
      \Illuminate\View\Middleware\ShareErrorsFromSession::class,
      \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
      \Illuminate\Routing\Middleware\SubstituteBindings::class,
      // \Illuminate\Session\Middleware\AuthenticateSession::class,
      \App\Http\Middleware\LocaleMiddleware::class,
    ]);

    $middleware->group('api', [
      // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
      'throttle:api',
      \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]);

    $middleware->alias([
      'auth' => Authenticate::class,
      'forceLogout' => ForceLogoutMiddleware::class
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    $exceptions->report(function (Handler $e) {
      // ...
    });
  })->create();

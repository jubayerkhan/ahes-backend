<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
  /**
   * The list of the inputs that are never flashed to the session on validation exceptions.
   *
   * @var array<int, string>
   */
  protected $dontFlash = [
    'current_password',
    'password',
    'password_confirmation',
  ];

  /**
   * Register the exception handling callbacks for the application.
   */
  public function register(): void
  {
    $this->reportable(function (Throwable $e) {
      //
    });
  }

  /**
   * Convert an authentication exception into an unauthenticated response.
   *
   * @param \Illuminate\Http\Request $request
   * @param \Illuminate\Auth\AuthenticationException $exception
   * @return \Illuminate\Http\Response
   */
  protected function unauthenticated($request, AuthenticationException $exception)
  {
    if ($request->expectsJson()) {
      $response = [
        'success' => false,
        'message' => 'Unauthenticated',
      ];

      abort(response()->json($response, 401));
    }

    $guard = Arr::get($exception->guards(), 0);
    switch ($guard) {
      case 'admin':
        $login = 'admin.login';
        break;
      case 'api':
        $login = 'api';
        break;
      case 'sanctum':
        $login = 'sanctum';
        break;
      default:
        $login = 'login';
        break;
    }

    if ($login == 'api' || $login == 'sanctum') {
      $response = [
        'success' => false,
        'message' => 'Unauthorized/Token has been expired',
      ];

      abort(response()->json($response, 401));
    } else {
      return redirect()->guest(route($login));
    }
  }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Authenticate extends Middleware
{
  protected $guards;

  public function handle($request, Closure $next, ...$guards)
  {
    $this->guards = $guards;
    return parent::handle($request, $next, ...$guards);
  }
  /**
   * Get the path the user should be redirected to when they are not authenticated.
   */
  protected function redirectTo(Request $request)
  {
    if (!$request->expectsJson()) {
      if (Arr::first($this->guards) == 'web') {
        return route('login');
      } else if (Arr::first($this->guards) == 'admin') {
        return route('admin.login');
      }

      if (Arr::first($this->guards) == 'api' || Arr::first($this->guards) == 'sanctum') {
        $response = [
          'success' => false,
          'message' => 'Unauthorized/Token has been expired',
        ];

        abort(response()->json($response, 401));
      }

      //default redirect
      return url('/');
    }
  }
}

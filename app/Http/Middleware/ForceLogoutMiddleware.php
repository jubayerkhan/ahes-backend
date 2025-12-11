<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceLogoutMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $user = $request->user();
    if ($user && !$user->status) {
      auth()->logout();

      $errors = ['email' => 'Your account is inactive, Please contact with admin'];
      return redirect()->back()->withErrors($errors);
    }
    return $next($request);
  }
}

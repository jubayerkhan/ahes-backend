<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {

    RateLimiter::for('api', function (Request $request) {
      return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    });

    Vite::useStyleTagAttributes(function (?string $src, string $url, ?array $chunk, ?array $manifest) {
      if ($src !== null) {
        return [
          'class' => preg_match("/(resources\/assets\/vendor\/scss\/(rtl\/)?core)-?.*/i", $src) ? 'template-customizer-core-css' : (preg_match("/(resources\/assets\/vendor\/scss\/(rtl\/)?theme)-?.*/i", $src) ? 'template-customizer-theme-css' : '')
        ];
      }
      return [];
    });

    //ALL AN-SETUPS
    if (env('HTTPS_ENABLE', false)) {
      URL::forceScheme('https');
    }

    Schema::defaultStringLength(191);
    Paginator::useBootstrapFive();
    //Old Password Validation
    Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
      return Hash::check($value, current($parameters));
    }, 'Old Password does not match');
    //OTP Validation
    Validator::extend('verify_otp', function ($attribute, $value, $parameters, $validator) {
      return Hash::check($value, current($parameters));
    }, 'OTP does not verified');
    //Custom Validation rule for bd mobile
    Validator::extend('bd_mobile', function ($attribute, $value, $parameters, $validator) {
      return preg_match('/^(01)[1-9]{1}[0-9]{8}$/', $value);
    }, 'Invalid mobile number format');
  }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{

  /**
   * Where to redirect users after resetting their password.
   *
   * @var string
   */
  protected $redirectTo = '/dashboard';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest:admin');
  }

  public function showResetForm(Request $request, $token = null)
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.admin.authentications.auth-reset-password-basic', compact('pageConfigs'))->with(
      ['token' => $token, 'email' => $request->email]
    );
  }

  public function reset(Request $request)
  {
    $messages = [
      'email.required' => 'The Email field is required.',
    ];

    $request->validate([
      'token' => 'required',
      'email' => 'required|email',
      'password' => 'required|min:6|confirmed',
    ], $messages);

    $status = Password::broker('admins')->reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function ($user, $password) {
        $user->forceFill([
          'password' => Hash::make($password),
        ])->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
      }
    );

    return $status === Password::PASSWORD_RESET
      ? redirect()->route('admin.login')->with('status', __($status))
      : back()->withErrors(['email' => [__($status)]]);
  }

  protected function guard()
  {
    return Auth::guard('admin');
  }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  public function showLinkRequestForm()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.user.authentications.auth-forgot-password-basic', compact('pageConfigs'));
  }

  public function sendResetLinkEmail(Request $request)
  {
    $messages = [
      'email.required' => 'The Email field is required.',
    ];
    $request->validate([
      'email' => 'required|email',
    ], $messages);

    $status = Password::sendResetLink(
      $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
      ? back()->with(['status' => __($status)])
      : back()->withErrors(['email' => __($status)]);
  }
}

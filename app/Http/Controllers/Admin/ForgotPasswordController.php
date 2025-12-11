<?php

namespace App\Http\Controllers\Admin;

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
    $this->middleware('guest:admin');
  }

  public function showLinkRequestForm()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.admin.authentications.auth-forgot-password-basic', compact('pageConfigs'));
  }

  public function sendResetLinkEmail(Request $request)
  {

    $messages = [
      'email.required' => 'The Email field is required.',
    ];
    $request->validate([
      'email' => 'required|email',
    ], $messages);

    try {
      $status = Password::broker('admins')->sendResetLink(
        $request->only('email')
      );
    } catch (\Exception $e) {
      // dd($e->getMessage());
      if (env('APP_DEBUG')) {
        return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
      } else {
        return redirect()->back()->with(['error' => 'Sorry! Something Went Wrong'])->withInput();
      }
    }

    return $status === Password::RESET_LINK_SENT
      ? back()->with(['status' => __($status)])
      : back()->withErrors(['email' => __($status)]);
  }
}

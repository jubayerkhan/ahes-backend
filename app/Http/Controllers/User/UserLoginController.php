<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
  public function __construct()
  {
    $this->middleware('guest', ['except' => ['logout']]);
  }

  public function robotText()
  {
    $settings = Helpers::getSiteSettings();
    $contents = (array_key_exists('ROBOT_TEXT_CONTENT', $settings) && $settings['ROBOT_TEXT_CONTENT']) ? $settings['ROBOT_TEXT_CONTENT'] :  "User-agent: * \nDisallow: ";

    return response($contents, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
  }

  public function showLogin()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.user.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function login(Request $request)
  {
    // Validate the form data
    $this->validate($request, [
      'email' => 'required|email',
      'password' => 'required',
    ]);

    // Attempt to log the user in
    if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $request->remember)) {
      // if successful, then redirect to their intended location
      return redirect()->intended(route('dashboard'));
    }

    // if unsuccessful, then redirect back to the login with the form data
    $errors = ['email' => trans('auth.failed')];
    return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors($errors);
  }

  public function logout()
  {
    Auth::guard('web')->logout();
    return redirect()->route('login');
  }
}

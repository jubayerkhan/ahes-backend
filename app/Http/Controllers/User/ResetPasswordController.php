<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller {
	/*
		    |--------------------------------------------------------------------------
		    | Password Reset Controller
		    |--------------------------------------------------------------------------
		    |
		    | This controller is responsible for handling password reset requests
		    | and uses a simple trait to include this behavior. You're free to
		    | explore this trait and override any methods you wish to tweak.
		    |
	*/

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
	public function __construct() {
		$this->middleware('guest');
	}

	public function showResetForm(Request $request, $token = null) {
		$pageConfigs = ['myLayout' => 'blank'];
		return view('content.authentications.auth-reset-password-basic', compact('pageConfigs'))->with(
			['token' => $token, 'email' => $request->email]
		);
	}

	public function reset(Request $request) {
    $messages = [
			'email.required' => 'The Email field is required.',
		];

		$request->validate([
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:6|confirmed',
		], $messages);

		$status = Password::reset(
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
		? redirect()->route('login')->with('status', __($status))
		: back()->withErrors(['email' => [__($status)]]);
	}

	protected function guard() {
		return Auth::guard();
	}
}

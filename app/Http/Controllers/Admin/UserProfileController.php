<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class UserProfileController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function index()
  {
    $user = Auth::guard('admin')->user();
    return view('content.admin.profile.index', compact('user'));
  }

  public function edit()
  {
    $user = Auth::guard('admin')->user();

    return view('content.admin.profile.edit', compact('user'));
  }

  public function update(Request $request)
  {
    $user = Auth::guard('admin')->user();
    // Validate the form data
    $messages = [
      'name.required' => 'The Name field is required.',
      'email.required' => 'The Email field is required.',
      'email.unique' => 'The Email already exists',
      'phone.required' => 'The Phone field is required',
      'phone.bd_mobile' => 'Invalid Phone number format.',
      'phone.unique' => 'The Phone already exists.',
    ];
    $this->validate($request, [
      'name' => [
        'required',
        'string',
        'max:255',
      ],
      'phone' => [
        'sometimes',
        'nullable',
        'bd_mobile',
      ],
      'image' => [
        'sometimes',
        'nullable',
        'image',
        'mimes:jpeg,png,jpg',
      ],
    ], $messages);

    $input = $request->only('name', 'phone');

    if ($request->file('image')) {
      $imagePath = Helpers::uploadFile($request->file('image'), null, Config::get('constants.USER_IMAGES'));
      $input['image'] = $imagePath;
    }

    $user->update($input);

    Session::flash('success', 'The Profile has been updated');

    return redirect()->route('admin.profile');
  }

  public function changePassword()
  {

    return view('content.admin.profile.changePassword');
  }

  public function changePasswordStore(Request $request)
  {
    $messages = [
      'old_password.required' => 'Current password is required',
      'old_password.old_password' => 'Current password is wrong',
      'password.required' => 'New Password is required',
      'password.confirmed' => 'New Passwords does not match',
      'password.min' => 'New Password must be at least 6 char long',
      'password.max' => 'New Password can be maximum 200 char long',
    ];

    $this->validate($request, [
      'old_password' => 'required|old_password:' . Auth::guard('admin')->user()->password,
      'password' => 'required|confirmed|min:6|max:255',
    ], $messages);

    $user = Auth::guard('admin')->user();

    $user['password'] = bcrypt($request->get('password'));

    $user->save();

    Session::flash('success', 'Your password has been changed');

    return redirect()->route('admin.profile');
  }
}

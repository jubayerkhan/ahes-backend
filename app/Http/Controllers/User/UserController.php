<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:web');
  }

  public function dashboard()
  {
    return view('content.user.dashboard');
  }

  public function index(Request $request)
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-users-read'])) {
      $users = User::orderBy('id', 'DESC');

      if ($request->get('id')) {
        $users->where('id', $request->get('id'));
      }

      if ($request->get('name')) {
        $users->where('name', 'LIKE', '%' . $request->get('name') . '%');
      }

      if ($request->get('email')) {
        $users->where('email', 'LIKE', '%' . $request->get('email') . '%');
      }

      if ($request->get('phone')) {
        $users->where('phone', 'LIKE', '%' . $request->get('phone') . '%');
      }

      if ($request->get('role_id')) {
        $users->where('role_id', $request->get('role_id'));
      }

      $users = $users->with('role')->paginate(50);
      $roles = Role::where('type', 'web')->pluck('display_name', 'id')->all();

      return view('content.user.users.index', compact('users', 'roles'));
    } else {
      return view('error.user-unauthorized');
    }
  }

  public function create(Request $request)
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-users-create'])) {
      $roles = Role::where('type', 'web')->where('status', 1)->pluck('display_name', 'id')->all();

      return view('content.user.users.create', compact('roles'));
    } else {
      return view('error.user-unauthorized');
    }
  }

  public function store(Request $request)
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-users-create'])) {
      $messages = [
        'role_id.required' => 'The Role field is required.',
        'name.required' => 'The Name field is required.',
        'email.required' => 'The Email field is required.',
        'email.unique' => 'The Email already exists',
        'phone.required' => 'The Phone field is required',
        'phone.bd_mobile' => 'Invalid Phone number format.',
        'phone.unique' => 'The Phone already exists.',
        'password.required' => 'The Password field is required.',
        'password_confirmation.required' => 'The Confirm Password field is required.',
      ];

      $this->validate($request, [
        'role_id' => 'required',
        'name' => 'required',
        'phone' => [
          'sometimes',
          'nullable',
          // 'bd_mobile',
        ],
        'email' => [
          'required',
          Rule::unique('users', 'email')->whereNull('deleted_at'),
          'email',
        ],
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required|min:6',
      ], $messages);

      $input = $request->all();
      unset($input['password_confirmation']);

      $input['password'] = bcrypt($request->get('password'));
      $input['user_id'] = Auth::guard('web')->user()->id;

      DB::beginTransaction();
      try {
        $user = User::create($input);

        if ($user->wasRecentlyCreated) {
          $user->syncRoles([$user->role_id]);
        }

        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
        // dd($e);
        Session::flash('warning', 'Something went wrong, Please try again later.');
        return redirect()->back()->withInput();
      }

      Session::flash('success', 'The User has been created');

      return redirect()->route('users.index');
    } else {
      return view('error.user-unauthorized');
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-users-read'])) {
      $user = User::findOrFail($id);

      return view('content.user.users.show', compact('user'));
    } else {
      return view('error.user-unauthorized');
    }
  }

  public function edit($id)
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-users-update'])) {
      $user = User::findOrFail($id);

      $roles = Role::where('type', 'web')->where('status', 1)->pluck('display_name', 'id')->all();

      return view('content.user.users.edit', compact('user', 'roles'));
    } else {
      return view('error.user-unauthorized');
    }
  }

  /**
   * Update a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-users-update'])) {
      $messages = [
        'role_id.required' => 'The Role field is required.',
        'name.required' => 'The Name field is required.',
        'email.required' => 'The Email field is required.',
        'email.unique' => 'The Email already exists',
        'phone.required' => 'The Phone field is required',
        'phone.bd_mobile' => 'Invalid Phone number format.',
        'phone.unique' => 'The Phone already exists.',
      ];

      $this->validate($request, [
        'role_id' => 'required',
        'name' => 'required',
        'phone' => [
          'sometimes',
          'nullable',
          // 'bd_mobile',
        ],
        'email' => [
          'required',
          Rule::unique('users', 'email')->whereNull('deleted_at')->ignore($id),
          'email',
        ],
      ], $messages);

      $input = $request->all();

      if (!$request->has('status')) {
        $input['status'] = 0;
      }

      $input['user_id'] = Auth::guard('web')->user()->id;

      $user = User::findOrFail($id);

      DB::beginTransaction();
      try {
        $user->update($input);

        if ($user->role_id > 0) {
          $user->syncRoles([$input['role_id']]);
        } else {
          $user->syncRoles([]);
        }

        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
        // dd($e);
        Session::flash('warning', 'Something went wrong, Please try again later.');
        return redirect()->back()->withInput();
      }

      Session::flash('success', 'The User has been updated');

      return redirect()->route('users.index');
    } else {
      return view('error.user-unauthorized');
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-users-delete'])) {
      if (Auth::guard('web')->user()->id == $id) {
        Session::flash('error', 'You cannot delete your own account');

        return redirect()->route('users.index');
      } else {
        $user = User::findOrFail($id);

        DB::beginTransaction();
        try {
          $user->update([
            'user_id' => Auth::guard('web')->user()->id,
          ]);

          $user->permissions()->sync([]);
          $user->syncRoles([]);

          $user->delete();

          DB::commit();
        } catch (\Exception $e) {
          DB::rollback();
          // dd($e);
          Session::flash('warning', 'Something went wrong, Please try again later.');
          return redirect()->back();
        }

        Session::flash('success', 'The User has been deleted');

        return redirect()->route('users.index');
      }
    } else {
      return view('error.user-unauthorized');
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function updatePassword($id)
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-users-update'])) {
      $user = User::findOrFail($id);
      return view('content.user.users.updatePassword', compact('user'));
    } else {
      return view('error.user-unauthorized');
    }
  }

  public function updatePasswordStore($id, Request $request)
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-users-update'])) {
      $messages = [
        'password.required' => 'Password field is required',
        'password_confirmation.required' => 'Confirm Password field is required',
      ];

      $this->validate($request, [
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required|min:6',
      ], $messages);

      $input = $request->only('password');
      $input['password'] = bcrypt($request->get('password'));
      $input['user_id'] = Auth::guard('web')->user()->id;
      $user = User::findOrFail($id);
      $user->update($input);

      Session::flash('success', 'User password has been updated');
      return redirect()->route('users.index');
    } else {
      return view('error.user-unauthorized');
    }
  }

  public function activityLog(Request $request)
  {
    if (Auth::guard('web')->user()->hasRole('admin')) {
      $logs = Activity::orderBy('id', 'DESC');

      if ($request->get('causer_type')) {
        $logs->where('causer_type', Config::get('constants.CAUSER_TYPES')[$request->get('causer_type')]);
      }

      if ($request->get('causer')) {
        $logs->where('causer_id', $request->get('causer'));
      }

      if ($request->get('event')) {
        $logs->where('event', $request->get('event'));
      }

      if ($request->get('model')) {
        $logs->where('subject_type', Config::get('constants.MODELS')[$request->get('model')]);
      }

      $logs = $logs->with('causer')->paginate(25);

      $users = User::pluck('name', 'id')->all();
      return view('content.user.users.activityLog', compact('logs', 'users'));
    } else {
      return view('error.user-unauthorized');
    }
  }
}

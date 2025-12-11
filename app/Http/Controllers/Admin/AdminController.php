<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Admin;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  public function dashboard()
  {

    return view('content.admin.dashboard');
  }

  public function index(Request $request)
  {
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-read'])) {
      $admins = Admin::orderBy('id', 'DESC');

      if ($request->get('id')) {
        $admins->where('id', $request->get('id'));
      }

      if ($request->get('name')) {
        $admins->where('name', 'LIKE', '%' . $request->get('name') . '%');
      }

      if ($request->get('email')) {
        $admins->where('email', 'LIKE', '%' . $request->get('email') . '%');
      }

      if ($request->get('phone')) {
        $admins->where('phone', 'LIKE', '%' . $request->get('phone') . '%');
      }

      if ($request->get('role_id')) {
        $admins->where('role_id', $request->get('role_id'));
      }

      $admins = $admins->with('role')->paginate(50);
      $roles = Role::where('type', 'admin')->pluck('display_name', 'id')->all();

      return view('content.admin.admins.index', compact('admins', 'roles'));
    } else {
      return view('error.admin-unauthorized');
    }
  }

  public function create(Request $request)
  {
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-create'])) {
      $roles = Role::where('type', 'admin')->where('status', 1)->pluck('display_name', 'id')->all();

      return view('content.admin.admins.create', compact('roles'));
    } else {
      return view('error.admin-unauthorized');
    }
  }

  public function store(Request $request)
  {
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-create'])) {
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
          Rule::unique('admins', 'email')->whereNull('deleted_at'),
          'email',
        ],
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required|min:6',
      ], $messages);

      $input = $request->all();
      unset($input['password_confirmation']);

      $input['password'] = bcrypt($request->get('password'));
      $input['admin_id'] = Auth::guard('admin')->user()->id;

      DB::beginTransaction();
      try {
        $admin = Admin::create($input);

        if ($admin->role_id > 0) {
          $admin->syncRoles([$admin->role_id]);
        }

        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
        // dd($e);
        Session::flash('warning', 'Something went wrong, Please try again later.');
        return redirect()->back()->withInput();
      }

      Session::flash('success', 'The Admin has been created');

      return redirect()->route('admin.admins.index');
    } else {
      return view('error.admin-unauthorized');
    }
  }
  // studied 
  // studied 
  // studied 
  // studied 
  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-read'])) {
      $admin = Admin::findOrFail($id);

      return view('content.admin.admins.show', compact('admin'));
    } else {
      return view('error.admin-unauthorized');
    }
  }

  public function edit($id)
  {
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-update'])) {
      $admin = Admin::findOrFail($id);

      $roles = Role::where('type', 'admin')->where('status', 1)->pluck('display_name', 'id')->all();

      return view('content.admin.admins.edit', compact('admin', 'roles'));
    } else {
      return view('error.admin-unauthorized');
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
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-update'])) {
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
          Rule::unique('admins', 'email')->whereNull('deleted_at')->ignore($id),
          'email',
        ],
      ], $messages);

      $input = $request->all();

      if (!$request->has('status')) {
        $input['status'] = 0;
      }

      $input['admin_id'] = Auth::guard('admin')->user()->id;

      $admin = Admin::findOrFail($id);

      DB::beginTransaction();
      try {
        $admin->update($input);

        if ($admin->role_id > 0) {
          $admin->syncRoles([$input['role_id']]);
        } else {
          $admin->syncRoles([]);
        }

        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
        // dd($e);
        Session::flash('warning', 'Something went wrong, Please try again later.');
        return redirect()->back()->withInput();
      }

      Session::flash('success', 'The Admin has been updated');

      return redirect()->route('admin.admins.index');
    } else {
      return view('error.admin-unauthorized');
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
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-delete'])) {
      if (Auth::guard('admin')->user()->id == $id) {
        Session::flash('error', 'You cannot delete your own account');

        return redirect()->route('admin.admins.index');
      } else {
        $admin = Admin::findOrFail($id);

        DB::beginTransaction();
        try {
          $admin->update([
            'admin_id' => Auth::guard('admin')->user()->id,
          ]);

          $admin->permissions()->sync([]);
          $admin->syncRoles([]);

          $admin->delete();

          DB::commit();
        } catch (\Exception $e) {
          DB::rollback();
          // dd($e);
          Session::flash('warning', 'Something went wrong, Please try again later.');
          return redirect()->back();
        }

        Session::flash('success', 'The Admin has been deleted');

        return redirect()->route('admin.admins.index');
      }
    } else {
      return view('error.admin-unauthorized');
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
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-update'])) {
      $admin = Admin::findOrFail($id);
      return view('content.admin.admins.updatePassword', compact('admin'));
    } else {
      return view('error.admin-unauthorized');
    }
  }

  public function updatePasswordStore($id, Request $request)
  {
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-admins-update'])) {
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
      $input['admin_id'] = Auth::guard('admin')->user()->id;
      $admin = Admin::findOrFail($id);
      $admin->update($input);

      Session::flash('success', 'Admin password has been updated');
      return redirect()->route('admin.admins.index');
    } else {
      return view('error.admin-unauthorized');
    }
  }



  public function activityLog(Request $request)
  {
    if (Auth::guard('admin')->user()->hasRole('admin')) {
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

      if ($request->get('log_ip')) {
        $logs->where('log_ip', 'LIKE', '%' . $request->get('log_ip') . '%');
      }

      if ($request->get('log_user_agent')) {
        $logs->where('log_user_agent', 'LIKE', '%' . $request->get('log_user_agent') . '%');
      }

      $logs = $logs->with('causer')->paginate(25);

      $users = Admin::pluck('name', 'id')->all();
      return view('content.admin.activityLog', compact('logs', 'users'));
    } else {
      return view('error.admin-unauthorized');
    }
  }
}

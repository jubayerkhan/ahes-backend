<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PermissionGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:web');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-roles-read'])) {
      $roles = Role::where('type', 'web')->orderBy('id', 'asc');
      if ($request->get('name')) {
        $roles->where('display_name', 'LIKE', '%' . $request->get('name') . '%')
          ->orWhere('name', 'LIKE', '%' . $request->get('name') . '%')
          ->orWhere('description', 'LIKE', '%' . $request->get('name') . '%');
      }
      $roles = $roles->paginate(50);

      return view('content.user.roles.index', compact('roles'));
    } else {
      return view('error.user-unauthorized');
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-roles-create'])) {
      $permissionGroups = PermissionGroup::where('type', 'web')->orderBy('priority')->where('status', 1)->with('permissions')->get();
      return view('content.user.roles.create', compact('permissionGroups'));
    } else {
      return view('error.user-unauthorized');
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-roles-create'])) {
      $messages = [
        'display_name.required' => 'The Name field is required.',
        'display_name.unique' => 'The Name already exists.',
        'description.required' => 'The Description field is required.',
        'permissions.required' => 'Please check permissions.',
      ];

      $this->validate($request, [
        'display_name' => [
          'required',
          'max:191',
          Rule::unique('roles', 'display_name')->where('type', 'web')->whereNull('deleted_at'),
        ],
        'description' => 'required|max:191',
        'permissions' => 'required|array',
      ], $messages);

      $input = $request->only('display_name', 'description', 'status');
      $input['name'] = Str::slug($request->display_name);
      $input['type'] = 'web';
      $input['action_id'] = Auth::guard('web')->user()->id;

      // dd($input);

      DB::beginTransaction();
      try {
        $role = Role::create($input);

        if ($request->get('permissions')) {
          $role->permissions()->sync($request->get('permissions'));
        }

        DB::commit();
        // all good
      } catch (\Exception $e) {
        // dd($e);
        DB::rollback();

        Session::flash('warning', 'something went wrong, Please try again later');
        return redirect()->back()->withInput();
      }

      Session::flash('success', 'The Role has been created');

      return redirect()->route('roles.index');
    } else {
      return view('error.user-unauthorized');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-roles-update'])) {
      $role = Role::where('type', 'web')->where('id', $id)->firstOrFail();
      if ($role->name == 'admin') {
        Session::flash('warning', 'Admin Role can not be modified');

        return redirect()->route('roles.index');
      }

      $permissionGroups = PermissionGroup::where('type', 'web')->orderBy('priority')->where('status', 1)->with('permissions')->get();
      return view('content.user.roles.edit', compact('role', 'permissionGroups'));
    } else {
      return view('error.user-unauthorized');
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-roles-update'])) {
      $role = Role::where('type', 'web')->where('id', $id)->firstOrFail();
      if ($role->name == 'admin') {
        Session::flash('warning', 'Admin Role can not be modified');

        return redirect()->route('roles.index');
      }

      $messages = [
        'display_name.required' => 'The Name field is required.',
        'display_name.unique' => 'The Name already exists.',
        'description.required' => 'The Description field is required.',
        'permissions.required' => 'Please check permissions.',
      ];

      $this->validate($request, [
        'display_name' => [
          'required',
          'max:191',
          Rule::unique('roles', 'display_name')->where('type', 'web')->whereNull('deleted_at')->ignore($id),
        ],
        'description' => 'required|max:191',
        'permissions' => 'required|array',
      ], $messages);

      $input = $request->only('display_name', 'description', 'status');
      $input['name'] = Str::slug($request->display_name);
      $input['action_id'] = Auth::guard('web')->user()->id;
      if (!$request->has('status')) {
        $input['status'] = 0;
      }

      DB::beginTransaction();
      try {
        $role->update($input);

        if ($request->get('permissions')) {
          $role->permissions()->sync($request->get('permissions'));
        }

        DB::commit();
        // all good
      } catch (\Exception $e) {
        // dd($e);
        DB::rollback();

        Session::flash('warning', 'something went wrong, Please try again later');
        return redirect()->back()->withInput();
      }

      Session::flash('success', 'The Role has been updated');

      return redirect()->route('roles.index');
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
    if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-roles-delete'])) {
      $role = Role::where('type', 'web')->where('id', $id)->firstOrFail();
      if ($role->name == 'admin') {
        Session::flash('warning', 'Admin Role can not be modified');

        return redirect()->route('roles.index');
      }
      if ($role->users->count() > 0) {
        Session::flash('warning', 'This Role already used, You can not be delete');

        return redirect()->route('roles.index');
      }

      DB::beginTransaction();
      try {
        $role->update([
          'action_id' => Auth::guard('web')->user()->id,
        ]);

        $role->permissions()->sync([]);
        $role->delete();

        DB::commit();
        // all good
      } catch (\Exception $e) {
        // dd($e);
        DB::rollback();

        Session::flash('warning', 'something went wrong, Please try again later');
        return redirect()->back()->withInput();
      }

      Session::flash('success', 'The Role has been deleted');

      return redirect()->route('roles.index');
    } else {
      return view('error.user-unauthorized');
    }
  }
}

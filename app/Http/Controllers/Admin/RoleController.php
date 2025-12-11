<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermissionGroup;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-roles-read'])) {
      $roles = Role::where('type', 'admin')->orderBy('id', 'asc');
      if ($request->get('name')) {
        $roles->where('display_name', 'LIKE', '%' . $request->get('name') . '%')
          ->orWhere('name', 'LIKE', '%' . $request->get('name') . '%')
          ->orWhere('description', 'LIKE', '%' . $request->get('name') . '%');
      }
      $roles = $roles->paginate(50);

      return view('content.admin.roles.index', compact('roles'));
    } else {
      return view('error.admin-unauthorized');
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-roles-create'])) {
      $permissionGroups = PermissionGroup::where('type', 'admin')->orderBy('id')->where('status', 1)->with('permissions')->get();
      return view('content.admin.roles.create', compact('permissionGroups'));
    } else {
      return view('error.admin-unauthorized');
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
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-roles-create'])) {
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
          Rule::unique('roles', 'display_name')->where('type', 'admin')->whereNull('deleted_at'),
        ],
        'description' => 'required|max:191',
        'permissions' => 'required|array',
      ], $messages);

      $input = $request->only('display_name', 'description', 'status');
      $input['name'] = Str::slug($request->display_name);
      $input['type'] = 'admin';
      $input['action_id'] = Auth::guard('admin')->user()->id;

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

      return redirect()->route('admin.roles.index');
    } else {
      return view('error.admin-unauthorized');
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
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-roles-update'])) {
      $role = Role::where('type', 'admin')->where('id', $id)->firstOrFail();
      if ($role->name == 'admin') {
        Session::flash('warning', 'Admin Role can not be modified');

        return redirect()->route('roles.index');
      }
      $permissionGroups = PermissionGroup::where('type', 'admin')->orderBy('id')->where('status', 1)->with('permissions')->get();
      return view('content.admin.roles.edit', compact('role', 'permissionGroups'));
    } else {
      return view('error.admin-unauthorized');
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
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-roles-update'])) {
      $role = Role::where('type', 'admin')->where('id', $id)->firstOrFail();
      if ($role->name == 'admin') {
        Session::flash('warning', 'Admin Role can not be modified');

        return redirect()->route('admin.roles.index');
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
          Rule::unique('roles', 'display_name')->where('type', 'admin')->whereNull('deleted_at')->ignore($id),
        ],
        'description' => 'required|max:191',
        'permissions' => 'required|array',
      ], $messages);

      $input = $request->only('display_name', 'description', 'status');
      $input['name'] = Str::slug($request->display_name);
      $input['action_id'] = Auth::guard('admin')->user()->id;
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

      return redirect()->route('admin.roles.index');
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
    if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->hasPermission(['admin-roles-delete'])) {
      $role = Role::where('type', 'admin')->where('id', $id)->firstOrFail();
      if ($role->name == 'admin') {
        Session::flash('warning', 'Admin Role can not be modified');

        return redirect()->route('admin.roles.index');
      }
      if ($role->users->count() > 0) {
        Session::flash('warning', 'This Role already used, You can not be delete');

        return redirect()->route('admin.roles.index');
      }

      DB::beginTransaction();
      try {;
        $role->update([
          'action_id' => Auth::guard('admin')->user()->id,
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

      return redirect()->route('admin.roles.index');
    } else {
      return view('error.admin-unauthorized');
    }
  }
}

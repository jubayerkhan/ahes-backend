<?php

namespace App\Http\Controllers\User;

use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AdminPermissionGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPermissionGroupController extends Controller {
	public function __construct() {
		$this->middleware('auth:web');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-permission-groups-read'])) {
			$adminPermissionGroups = AdminPermissionGroup::orderBy('name', 'asc')->paginate(50);
			// dd($adminPermissionGroups);
			return view('user.admin-permission-groups.index', compact('adminPermissionGroups'));
		} else {
			return view('error.user-unauthorized');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-permission-groups-create'])) {
			$used = DB::table('admin_permission_group_permission')->pluck('permission_id', 'permission_id')->all();
			// dd($used);
			$permissions = Permission::whereNotIn('id', $used)->pluck('display_name', 'id')->all();
			return view('user.admin-permission-groups.create', compact('permissions'));
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
	public function store(Request $request) {
		if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-permission-groups-create'])) {
			$messages = [
				'name.required' => 'The Name field is required.',
				'name.unique' => 'The Name already has been taken.',
			];

			$this->validate($request, [
				'name' => [
					'required',
					Rule::unique('admin_permission_groups')->whereNull('deleted_at'),
				],
			], $messages);

			$input = $request->all();
			$input['user_id'] = Auth::guard('web')->user()->id;
			$input['key'] = Str::slug($request->name);

			$adminPermissionGroup = AdminPermissionGroup::create($input);

			if ($request->get('permissions')) {
				$adminPermissionGroup->permissions()->sync($request->get('permissions'));
			}

			Session::flash('success', 'The Admin Permission Group has been created');

			return redirect()->route('admin-permission-groups.index');
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
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-permission-groups-update'])) {
			//check existence
			$permission_group = DB::table('admin_permission_group_permission')->where('admin_permission_group_id', $id)->pluck('permission_id', 'permission_id')->all();
			$permission_admin_user = DB::table('permission_user')->where('user_type', 'App\User')->pluck('permission_id', 'permission_id')->all();
			$result = array_intersect($permission_group, $permission_admin_user);
			if (1 != 1 && $result) {
				Session::flash('warning', 'This Permission Group already assigned an user');
				return redirect()->route('admin-permission-groups.index');
			}
			//end check existence
			$used = DB::table('admin_permission_group_permission')->where('admin_permission_group_id', '<>', $id)->pluck('permission_id')->all();

			$adminPermissionGroup = AdminPermissionGroup::findOrFail($id);
			$permissions = Permission::whereNotIn('id', $used)->pluck('display_name', 'id')->all();
			$permissionGroup = [];

			foreach ($adminPermissionGroup->permissions as $permission) {
				$permissionGroup[] = $permission->id;
			}

			return view('user.admin-permission-groups.edit', compact('adminPermissionGroup', 'permissions', 'permissionGroup'));
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
	public function update(Request $request, $id) {
		if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-permission-groups-update'])) {
			$messages = [
				'name.required' => 'The Name field is required.',
				'name.unique' => 'The Name already has been taken.',
			];

			$this->validate($request, [
				'name' => [
					'required',
					Rule::unique('admin_permission_groups')->whereNull('deleted_at')->ignore($id),
				],
			], $messages);

			//check existence
			$permission_group = DB::table('admin_permission_group_permission')->where('admin_permission_group_id', $id)->pluck('permission_id', 'permission_id')->all();
			$permission_admin_user = DB::table('permission_user')->where('user_type', 'App\User')->pluck('permission_id', 'permission_id')->all();
			$result = array_intersect($permission_group, $permission_admin_user);
			if (1 != 1 && $result) {
				Session::flash('warning', 'This Permission Group already assigned an user');
				return redirect()->route('admin-permission-groups.index');
			}

			$input = $request->all();
			$input['user_id'] = Auth::guard('web')->user()->id;
			if (!$request->has('status')) {
				$input['status'] = 0;
			}

			$adminPermissionGroup = AdminPermissionGroup::findOrFail($id);
			$adminPermissionGroup->update($input);

			$adminPermissionGroup->permissions()->sync($request->get('permissions'));

			Session::flash('success', 'The Admin Permission Group has been updated');

			return redirect()->route('admin-permission-groups.index');
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
	public function destroy($id) {
		if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-permission-groups-delete'])) {
			//check existence
			$permission_group = DB::table('admin_permission_group_permission')->where('admin_permission_group_id', $id)->pluck('permission_id', 'permission_id')->all();
			$permission_admin_user = DB::table('permission_user')->where('user_type', 'App\User')->pluck('permission_id', 'permission_id')->all();
			$result = array_intersect($permission_group, $permission_admin_user);
			if (1 != 1 && $result) {
				Session::flash('warning', 'This Permission Group already assigned an user');
				return redirect()->route('admin-permission-groups.index');
			}
			//end check existence

			$adminPermissionGroup = AdminPermissionGroup::findOrFail($id);
			$adminPermissionGroup->update([
				'user_id' => Auth::guard('web')->user()->id,
			]);
			$adminPermissionGroup->delete();
			$adminPermissionGroup->permissions()->sync([]);

			Session::flash('success', 'The Admin Permission Group has been deleted');

			return redirect()->route('admin-permission-groups.index');
		} else {
			return view('error.user-unauthorized');
		}
	}

	public function permissionList() {
		if (Auth::guard('web')->user()->hasRole('admin') || Auth::guard('web')->user()->hasPermission(['user-permission-groups-read'])) {
			$permissionGroups = AdminPermissionGroup::where('status', 1)->with('permissions')->get();
			// dd($adminPermissionGroups);
			return view('user.admin-permission-groups.permissionList', compact('permissionGroups'));
		} else {
			return view('error.user-unauthorized');
		}
	}
}

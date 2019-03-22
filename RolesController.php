<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use App\Role;

class RolesController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$roles = Role::all();
		return view('admin.roles.index')->with(compact('roles'));
	}

	public function show(Role $role)
	{

	}

	public function create() {
		$routes = getNamedRoutes();
		return view('admin.roles.create_edit')->with(compact('routes'));
	}

	public function store(Request $request) {
		$name = $request->input('name');
		$routes = $request->input('routes');
		$role = new Role();

		$role->name = $name;

		$role->routes = json_encode($routes);

		$role->save();

		return redirect('admin/roles')->with('success', $role->name . ' has been added Successfully');
	}

	public function edit(Role $role) {
		$routes = getNamedRoutes();
		return view('admin.roles.create_edit')->with(compact('role','routes'));
	}

	public function update(Request $request, Role $role) {
		$name = $request->input('name');
		$role->name = $name;
		$routes = $request->input('routes');
		$role->routes = json_encode($routes);
		$role->save();
		return redirect('admin/roles')->with('success', $role->name . ' has been updated Successfully');
	}

	public function destroy(Request $request, Role $role) {
		if ($request->ajax()) {
			$role->delete();
			return response()->json(['success' => 'Role has been deleted successfully']);
		} else {
			return 'You can\'t proceed in delete operation';
		}
	}
}

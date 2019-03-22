<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserInfo;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;

class UsersController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		if (hasAccess('users.index')) {
			$users = User::select('users.*','roles.name as roleName','roles.id as roleId')
			             ->leftJoin('roles','roles.id','=','users.role_id')->get();
			return view('admin.users.index')->with(compact('users','roles'));
		} else {
			return abort(404);
		}

	}

	public function create()
	{
		$roles = Role::all();

		return view('admin.users.create_edit')->with(compact('roles'));
	}

	public function store(Request $request)
	{
		$account = [];

		$avatar = 'avatar.png';

		if ($request->hasFile('avatar')) {
			$destinationPath = public_path() . '/uploads/avatars';

			$avatar = hash('sha256', mt_rand()) . '.' . $request->file('avatar')->getClientOriginalExtension();

			$request->file('avatar')->move($destinationPath, $avatar);

			\Image::make(asset('uploads/avatars/' . $avatar))->fit(300, null, null, 'top-left')->save('uploads/avatars/' . $avatar);
		}

		$account['avatar'] = $avatar;

		$account['name'] = $request->input('name');

		$account['email'] = $request->input('email');
		$account['mobile'] = $request->input('mobile');
		$account['address'] = $request->input('address');
		$account['role_id'] = $request->input('role');

		$user = new User($account);

		$user->password = bcrypt($request->input('password'));
		$role = Role::select('name')->where('id',$request->input('role'))->first();

		$user->save();
		$user->role = $role->name;
		Mail::to($request->input('email'))->send(new UserInfo($user));
		$status_message = $user->name . ' has been added Successfully.';

		return redirect('admin/users')->with('success', $status_message);
	}

	public function show(User $user)
	{
		return view('admin.users.show')->with(compact('user'));
	}

	public function edit(User $user)
	{
		$roles = Role::all();

		return view('admin.users.create_edit')->with(compact('user', 'roles'));
	}

	public function update(Request $request, User $user)
	{
		if ($request->hasFile('avatar')) {
			$destinationPath = public_path() . '/uploads/avatars';

			if ($user->avatar != "uploads/avatars/avatar.png") {
				@unlink($user->avatar);
			}

			$avatar = hash('sha256', mt_rand()) . '.' . $request->file('avatar')->getClientOriginalExtension();

			$request->file('avatar')->move($destinationPath, $avatar);

			\Image::make(asset('uploads/avatars/' . $avatar))->fit(300, null, null, 'top-left')->save('uploads/avatars/' . $avatar);

			$user->avatar = $avatar;
		}

		$user->name = $request->input('name');

		$user->email = $request->input('email');
		$user->mobile = $request->input('mobile');
		$user->address = $request->input('address');
		$user->updated_at = Carbon::now();
		$user->role_id = $request->input('role');

		if ($request->input('password')) {
			$user->password = bcrypt($request->input('password'));
		}

		$user->save();

		$status_message = $user->name . ' has been updated Successfully.';

		return redirect('admin/users')->with('success', $status_message);
	}

	public function destroy(Request $request, User $user)
	{
		if ($request->ajax()) {
			$user->delete();
			return response()->json(['success' => 'User has been deleted successfully']);
		} else {
			return 'You can\'t proceed in delete operation';
		}
	}
}

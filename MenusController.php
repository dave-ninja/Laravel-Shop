<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Menu;

class MenusController extends Controller
{
	public function index()
	{
		$menus = Menu::all();
		return view('admin.menus.index')->with(compact('menus'));
	}

	public function create()
	{
		return view('admin.menus.create_edit');
	}

	public function store(Request $request)
	{
		if($request->status == null) {
			$request->status = 0;
		}
		$menu = Menu::create($request->except('_token'));

		$menu->status = $request->status;

		$menu->save();

		return redirect('admin/menus')->with('success', 'New Menu Added Successfully');
	}

	public function show($id)
	{
		return $this->index();
	}

	public function edit(Menu $menu)
	{
		return view('admin.menus.create_edit')->with(compact('menu'));
	}

	public function update(Request $request, Menu $menu)
	{
		$menu->title = $request->input('title');
		$menu->location = $request->input('location');
		$menu->url = $request->input('url');
		$menu->item_order = $request->input('item_order');
		if($request->input('status') == null) {
			$menu->status = 0;
		} else{
			$menu->status = $request->input('status');
		}


		$menu->save();

		return redirect('admin/menus')->with('success', $menu->title . ' Menu Updated Successfully');
	}

	public function destroy(Request $request, Menu $menu)
	{
		if ($request->ajax()) {
			$menu->delete();
			return response()->json(['success' => 'Menu has been deleted successfully']);
		} else {
			return 'You can\'t proceed in delete operation';
		}
	}
}

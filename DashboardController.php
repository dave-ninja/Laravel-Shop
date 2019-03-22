<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Page;
use App\Product;

class DashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$users = User::all()->count();
		$pages = Page::page()->count();
		$posts = Page::post()->count();
		$products = Product::where('status',1)->get()->count();

		return view('admin.dashboard')->with(compact('users','pages','posts','products'));
	}
}

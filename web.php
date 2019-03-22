<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('logout', function() {
	Auth::logout();
	return redirect('/');
});

Route::middleware('web')->group(function () {

	Route::get('/', 'FrontendController@index');

	Route::get('/home', 'FrontendController@index');

	Route::get('/{slug}', 'FrontendController@staticPages');

	Route::get('/blog', 'FrontendController@blog');

	Route::get('/blog/{slug}', 'FrontendController@post');

	Route::post('/contact-us', 'FrontendController@contactUsSubmit');

	Route::get('/product', 'FrontendController@product');

	Route::get('/product/{slug}', 'FrontendController@singleProduct');

	//Route::post('stripe/webhook', '\Laravel\Cashier\WebhookController@handleWebhook');

	Route::prefix('member')->group(function () {
		Route::get('/home', ['as' => 'member.home', 'uses' => 'MemberController@index']);
		Route::get('/profile', ['as' => 'member.profile', 'uses' => 'MemberController@profile']);
		Route::post('/profile/edit', ['as' => 'member.profile.update', 'uses' => 'MemberController@updateProfile']);
		Route::get('/profile/edit', ['as' => 'member.profile.edit', 'uses' => 'MemberController@editProfile']);

	});

});

Route::middleware('admin')->group(function () {

	Route::prefix('admin')->group(function () {
		// DASHBOARD
		Route::get('/dashboard', 'Admin\DashboardController@index');

		// ROLES
		Route::resource('roles', 'Admin\RolesController');
		Route::get('roles/{role}/update', 'Admin\RolesController@update');

		// USERS
		Route::resource('users', 'Admin\UsersController');
		Route::get('users/{user}/update', 'Admin\UsersController@update');

		// PAGES
		Route::resource('pages', 'Admin\PagesController');
		Route::get('pages/{page}/update', 'Admin\PagesController@update');

		// MENUS
		Route::resource('menus', 'Admin\MenusController');
		Route::get('menus/{menu}/update', 'Admin\MenusController@update');

		// SETTINGS
		Route::get('settings/create/{type}', ['as' => 'admin.settings.create.type', 'uses' => 'Admin\SettingsController@createForm']);
		Route::get('settings/download/{settings}', ['as' => 'admin.settings.download', 'uses' => 'Admin\SettingsController@fileDownload']);
		Route::resource('settings', 'Admin\SettingsController');
		Route::get('settings/{setting}/update', 'Admin\SettingsController@update');

		// PRODUCTS
		//Route::resource('products', 'Admin\ProductsController');
		//Route::get('products/{product}/update', 'Admin\ProductsController@update');
	});

});
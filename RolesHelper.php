<?php

function hasAccess($route = '')
{
	if (Auth::user()->role->name == 'Admin') {
		return true;
	}
	$routes = json_decode(Auth::user()->role->routes);

	if (isset($routes)) {
		return in_array($route, $routes);
	}
	return false;
}
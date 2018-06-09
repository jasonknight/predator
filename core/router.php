<?php
return function ($config = []) {
	return function ($cmd, ...$args) use ($config) {
		static $config;
		static $routes = [];
		if ( $cmd == 'add_route' ) {
			echo "Adding route\n";
			foreach ( $args[0] as $k=>$v ) {
				$routes[$k] = $v;
			}
		}
		if ( $cmd == 'route' ) {
			foreach ( $routes as $route=>$cb ) {
				if ( preg_match( $route, $args[0],$matches ) ) {
					echo "$route matched\n";
					if ( $cb($matches) ) {
						return;
					}
				}
			}
		}
		if ( $cmd == 'show_routes' ) {
			foreach ( $routes as $route=>$cb ) {
				echo "$route\n";
			}
		}
	};
};

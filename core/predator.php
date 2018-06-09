<?php
return function ($config = []) {
	return function ($cmd, ...$args) use ($config) {
		static $routes = [];
		if ( $cmd == 'add_route' ) {
			foreach ( $args[0] as $k=>$v ) {
				$routes[$k] = $v;
			}
		}
		if ( $cmd == 'route' ) {
			foreach ( $routes as $route=>$cb ) {
				echo "route=$route\n";
				if ( preg_match( $route, $args[0],$matches ) ) {
					echo "$route matched\n";
					print_r($matches);
					return $cb($matches);
				}
			}
		}
		if ( $cmd == 'show_routes' ) {
			foreach ( $routes as $route ) {
				print_r($route);
			}
		}
		if ( $cmd == 'show_config' ) {
			print_r($config);
		}
	};
};

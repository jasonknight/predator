<?php
return function () {
	return function ($config, $cmd, ...$args) {
		static $routes = [];
		if ( $cmd == 'add_route' ) {
			foreach ( $args[0] as $k=>$v ) {
				$routes[$k] = $v;
			}
			return $routes;
		}
		if ( $cmd == 'route' ) {
			$matching_routes = [];
			foreach ( $routes as $route=>$cb ) {
				if ( isset($cb['matcher']) && is_callable($cb['matcher']) ) {
					$fn = $cb['matcher'];
					$matches = $fn($route,$args[0]);
					if ( ! empty($matches) ) {
						$cb['matches'] = $matches;
						$matching_routes[$route] = $cb;
					}
				} else {
					if ( preg_match( $route, $args[0],$matches ) ) {
						$cb['matches'] = $matches;
						$matching_routes[$route] = $cb;
					}
				}
			}
			return $matching_routes;
		}
		if ( $cmd == 'print_routes' ) {
			foreach ( $routes as $route=>$cb ) {
				if ( isset($args[0]) && is_callable($args[0]) ) {
					$fn = $args[0];
					$fn($route,$cb);
				}
			}
			return $routes;
		}
	};
};

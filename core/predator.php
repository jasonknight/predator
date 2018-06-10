<?php
return function ($config = [], $router = null) {
	return function ($cmd, ...$args) use ($config,$router) {		
		static $routes = [];
		static $router;
		if ( $router == null ) {
			echo "Creating Router\n";
			$router = include(__DIR__ . "/router.php" );
			$router = $router($config);
		}
		if ( preg_match("/(route|routes)$/", $cmd) ) {
			$router_args = func_get_args();
			array_unshift($router_args,$routes);
			array_unshift($router_args,$config);
			return ($routes = call_user_func_array($router,$router_args));
		}
		if ( $cmd == 'print_config' ) {
			print_r($config);
		}
	};
};

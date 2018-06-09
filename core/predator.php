<?php
return function ($config = [], $router = null) {
	return function ($cmd, ...$args) use ($config,$router) {		
		static $router;
		if ( $router == null ) {
			echo "Creating new router\n";
			$router = include(__DIR__ . "/router.php" );
			$router = $router($config);
		}
		if ( preg_match("/(route|routes)$/", $cmd) ) {
			return call_user_func_array($router,func_get_args());
		}
		if ( $cmd == 'show_config' ) {
			print_r($config);
		}
	};
};

<?php
function logger($info=null,$error=null,$debug=null,$receiver=null) {
	return function ($type,...$params) use ($info,$error,$debug, $receiver) {
		$default_logger = function (...$params) {
			$looper = function ($keys,$values) use (&$looper) {
				
				if ( empty($keys) || empty($values) ) {
					return [];
				}
				$car1 = array_shift($keys);
				$car2 = array_shift($values);
				if ( is_array($car2) ) {
					return array_merge(
						["$car1 = [" . join(", ", $looper(array_keys($car2),array_values($car2))) . "]"],
						$looper($keys,$values)
					);
				} else {
					return array_merge(
						["$car1=$car2"],
						$looper($keys,$values)
					);
				}
			};
			return join( ", ", $looper(array_keys($params), array_values($params) ) );
		};
		$default_receiver = function ($str) {
			echo $str . "\n";
		};
		if ( ! $info ) { $info = $default_logger; }
		if ( ! $error ) { $error = $default_logger; }
		if ( ! $debug ) { $debug = $default_logger; }
		if ( ! $receiver ) { $receiver = $default_receiver; }
		if ( $type == 'info' ) {
			return $receiver('INFO: ' . call_user_func_array($info,$params));
		}	
		if ( $type == 'error' ) {
			return $receiver('ERROR: ' . call_user_func_array($error,$params));
		}
		if ( $type == 'debug' ) {
			return $receiver('DEBUG: ' .call_user_func_array($debug,$params));
		}
	};
}

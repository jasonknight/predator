<?php
function pipe(...$args) {
	if ( is_callable($args[0]) ) {
		$fn = $args[0];
		$ret = $fn();
		array_unshift($args,$ret);
		return call_user_func_array(__FUNCTION__,$args);
	} else {
		if ( isset($args[0]) ) {
			$car = $args[0];
		} else {
			throw new \Exception("pipe requires you pass it something");
		}
		if ( isset($args[1]) ) {
			$cdar = $args[1];
			if ( ! is_callable($cdar) ) {
				return $car;
			}
		} else {
			return $car;
		}

		$cddr = array_slice($args,2);
		if ( ! is_array($car) ) {
			$car = [$car];
		}
		$ret = call_user_func_array($cdar,$car);
		array_unshift($cddr,$ret);
		return call_user_func_array(__FUNCTION__,$cddr);
	}
}

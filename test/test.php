<?php
include __DIR__ . "/../core/logger.php";
function fail($msg) {
	echo "FAIL: $msg\n";
}
function pass($msg) {
	echo "PASS: $msg\n";
}
function run() {
	foreach ( get_defined_functions()['user'] as $f ) {
		if ( preg_match("/^test_/", $f) ) {
			$f();
		}
	}
}

function test_logger() {
	$l = logger(function ($str) { echo "CUSTOM" . $str . "\n";});
	echo $l('info', 'hello', 'world');
	echo $l('error',['goodbye' => 'world']);
}


run();

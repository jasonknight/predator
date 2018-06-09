<?php
require_once("../core/utils.php");
// Basic Example
$predator = include("../core/predator.php");
$app = $predator(['env'=>'development']);
$test = "Yolo\n";
$app('add_route',['/\/$/' => function() use ($test) {
	echo $test;
	return true;
}]);
$app('show_routes');
$app('show_config');
$app('route','/');


echo pipe(function() { return "Hello"; }, function($s) { return strtoupper($s); });
echo pipe('xxx');

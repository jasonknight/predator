<?php
$predator = include("../core/predator.php");
$app = $predator(['env'=>'development']);
$test = "Yolo\n";
$app('add_route',['/\/$/' => function() use ($test) {
	echo $test;
}]);
$app('show_routes');
$app('show_config');
$app('route','/');

$app = $predator(['env'=>'production']);
$app('add_route',['/hello_world' => function() {}]);
$app('show_routes');
$app('show_config');


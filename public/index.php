<?php
require_once(__DIR__ ."/../core/utils.php");
// Basic Example
$predator = include(__DIR__ . "/../core/predator.php");
$app = $predator(['env'=>'development']);
$test = "Yolo\n";
$app('add_route',[
	'/\/$/' => [
		'matched' => function() use ($test) {
			echo $test;
			return true;
		},
		'matcher' => function ($route,$path) {
				if ( preg_match($route,$path,$matches) ) {
					return $matches;
				}
				return [];
			},
	],
	'/^\/hello\/world\/(\d+)$/' => [
		'matched' => function(...$args) {
			echo "YOLO\n";
		},
	]
]);
$app('print_routes');
$app('print_config');
$callbacks = $app('route','/hello/world/5576');
print_r($callbacks);


echo pipe(function() { return "Hello"; }, function($s) { return strtoupper($s); });
echo pipe('xxx');
echo pipe(function() { return ['1','2']; },function($x,$y) {return "$x,$y";});

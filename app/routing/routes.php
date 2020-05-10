<?php

$routes = [
	"/" => function (array $parameters) {
		return new \Shakyou\TopPageController($parameters);
	},
	"/text/%d" => function (array $parameters) {
		return new \Shakyou\TextController($parameters);
	},
	"/dump" => function(array $parameters) {
		return new \Shakyou\DumpController($parameters);
	},
];

return $routes;

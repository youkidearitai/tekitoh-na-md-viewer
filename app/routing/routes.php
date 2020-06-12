<?php

use Psr\Container\ContainerInterface;

$routes = [
	"/" => function (array $parameters, ContainerInterface $container) {
		return new \Shakyou\TopPageController($parameters, $container);
	},
	"/text/%d" => function (array $parameters, ContainerInterface $container) {
		return new \Shakyou\TextController($parameters, $container);
	},
	"/dump" => function(array $parameters, ContainerInterface $container) {
		return new \Shakyou\DumpController($parameters, $container);
	},
	"/convert/html-to-md" => function(array $parameters, ContainerInterface $container) {
		return new \Shakyou\ConvertMarkdownController($parameters, $container);
	},
];

return $routes;

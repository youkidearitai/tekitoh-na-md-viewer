<?php

use Psr\Container\ContainerInterface;

$routes = [
	"/" => function (array $parameters, ContainerInterface $container) {
		return new \Shakyou\TopPageController($parameters, $container);
	},
	"/text/%s" => function (array $parameters, ContainerInterface $container) {
		return new \Shakyou\TextController($parameters, $container);
	},
	"/dump" => function(array $parameters, ContainerInterface $container) {
		return new \Shakyou\DumpController($parameters, $container);
	},
	"/convert/html-to-md" => function(array $parameters, ContainerInterface $container) {
		return new \Shakyou\ConvertMarkdownController($parameters, $container);
	},
	"/info.php" => function(array $parameters, ContainerInterface $container) {
		phpinfo();
	}
];

return $routes;

<?php

$routes = [
	"/" => [
		"title" => "TOP PAGE",
		"view" => function (string $contents) : string {
			return "TOP PAGE";
		},
	],
	"/text/%d" => [
		"title" => "pages",
		"view" => function(string $contents) : string {
			return $contents;
		},
	],
	"/dump" => [
		"title" => "DUMP method",
		"view" => function (string $contents) : string {
			\ob_start();
			\study_extension_dump("Original method study_extension_dump");
			\study_extension_dump($_SERVER);
			$contents = \ob_get_contents();
			\ob_end_clean();
			return "<pre>" . h($contents) . "</pre>";
		},
	],
];

return $routes;

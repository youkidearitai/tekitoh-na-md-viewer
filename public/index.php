<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use Michelf\MarkdownExtra;

define("VIEW_PATH", \dirname(__DIR__) . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);
define("TEMPLATE_PATH", VIEW_PATH . 'template' . DIRECTORY_SEPARATOR);
define("MARKDOWN_PATH", VIEW_PATH . 'markdown' . DIRECTORY_SEPARATOR);
define("MARKDOWN_SHAKYOU_PREFIX", 'shakyou_dump_');

class NotFoundException extends \Exception {
	public function __construct($message, $code = 0, Exception $previous = null) {
		header("HTTP/1.0 404 Not Found");
		parent::__construct($message, $code, $previous);
	}
}

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

function parseRouteNumber(string $request, string $router) {
	$numbers = \sscanf($request, $router);
	if (\count($numbers) != 1) {
		return false;
	}

	return $numbers[0] ?? false;
}

function readMarkdown(int $num) {
	$path = MARKDOWN_PATH . MARKDOWN_SHAKYOU_PREFIX . strval($num) . '.md';

	if (!\file_exists($path)) {
		throw new NotFoundException("404 Not Found");
	}

	$contents = \file_get_contents($path);

	if (!\is_string($contents)) {
		throw new NotFoundException("404 Not Found");
	}

	return MarkdownExtra::defaultTransform($contents);
}

function h($str) {
	return \htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

$contents = null;

foreach ($routes as $key => $val) {
	if ($key === $_SERVER["REQUEST_URI"]) {
		$contents = $val["view"]("");
		break;
	}

	$number = parseRouteNumber($_SERVER["REQUEST_URI"], $key);

	if ($number !== false) {
		$contents = $val["view"](readMarkdown($number));
		break;
	}
}

if (!isset($contents)) {
	throw new NotFoundException("404 Not Found");
}

require TEMPLATE_PATH . 'default.html';

<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

define("ROOT", \dirname(__DIR__) . DIRECTORY_SEPARATOR);

define("LIB_PATH", ROOT . 'lib' . DIRECTORY_SEPARATOR);
define("ROUTING_PATH", ROOT . 'routing' . DIRECTORY_SEPARATOR);
define("VIEW_PATH", ROOT . 'view' . DIRECTORY_SEPARATOR);
define("TEMPLATE_PATH", VIEW_PATH . 'template' . DIRECTORY_SEPARATOR);
define("MARKDOWN_PATH", VIEW_PATH . 'markdown' . DIRECTORY_SEPARATOR);
define("MARKDOWN_SHAKYOU_PREFIX", 'shakyou_dump_');

require_once ROUTING_PATH . 'routes.php';
require_once LIB_PATH . 'functions.php';

class NotFoundException extends \Exception {
	public function __construct($message, $code = 0, Exception $previous = null) {
		header("HTTP/1.0 404 Not Found");
		parent::__construct($message, $code, $previous);
	}
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

<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

define("ROOT", \dirname(__DIR__) . DIRECTORY_SEPARATOR);

define("SRC_PATH", ROOT . 'src' . DIRECTORY_SEPARATOR);
define("APP_PATH", ROOT . 'app' . DIRECTORY_SEPARATOR);
define("LIB_PATH", SRC_PATH . 'lib' . DIRECTORY_SEPARATOR);
define("ROUTING_PATH", APP_PATH . 'routing' . DIRECTORY_SEPARATOR);
define("VIEW_PATH", ROOT . 'view' . DIRECTORY_SEPARATOR);
define("TEMPLATE_PATH", VIEW_PATH . 'template' . DIRECTORY_SEPARATOR);
define("MARKDOWN_PATH", VIEW_PATH . 'markdown' . DIRECTORY_SEPARATOR);
define("MARKDOWN_SHAKYOU_PREFIX", 'shakyou_dump_');

define("DEBUG", true);

require_once ROUTING_PATH . 'routes.php';

$controller = null;
$container = include LIB_PATH . 'container.php';

foreach ($routes as $key => $val) {
	$param = parseRouteParam($_SERVER["REQUEST_URI"], $key);

	if ($param !== false) {
		$controller = $val($param, $container);
		break;
	}
}

if (!isset($controller)) {
	throw new NotFoundException("404 Not Found");
}

$controller->execute();

$twig = $container->get("view");
echo $twig->render('default.html', ['controller' => $controller]);

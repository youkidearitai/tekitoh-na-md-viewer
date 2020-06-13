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

$routes = include ROUTING_PATH . 'routes.php';
$container = include LIB_PATH . 'container.php';

use Middle\ProcessMiddleware;
use Middle\ErrorMiddleware;
use Handler\RequestHandler;

$handler = new RequestHandler();
$middle = new ErrorMiddleware($routes, $container);
$middle->add(new ProcessMiddleware($routes, $container));
$middle->process($handler);

<?php
namespace Handler;
use Psr\Container\ContainerInterface;
use Error\NotFoundException;

class RequestHandler implements HandlerInterface {
	public function handle(array $routes, ContainerInterface $container) {
		$controller = null;

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
		return $twig->render('default.html', ['controller' => $controller]);
	}
}

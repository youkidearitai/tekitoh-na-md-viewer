<?php

namespace Middle;
use Handler\RequestHandler;
use Psr\Container\ContainerInterface;

class ProcessMiddleware extends BaseMiddleware {
	public function process(RequestHandler $handler) {
		echo $handler->handle($this->routes, $this->container);
	}
}

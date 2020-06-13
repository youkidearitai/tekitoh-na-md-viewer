<?php

namespace Middle;
use Handler\RequestHandler;
use Psr\Container\ContainerInterface;

abstract class BaseMiddleware implements MiddlewareInterface {
	public MiddlewareInterface $middle;

	public function __construct(array $routes, ContainerInterface $container) {
		$this->routes = $routes;
		$this->container = $container;
	}

	public function add(MiddlewareInterface $middle) {
		$this->middle = $middle;
		return $this;
	}

	public function process(RequestHandler $handler) {
		$this->middle->process($handler);
	}
}

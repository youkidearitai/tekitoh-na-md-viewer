<?php

namespace Handler;
use Psr\Container\ContainerInterface;

interface HandlerInterface {
	public function handle(array $routes, ContainerInterface $container);
}

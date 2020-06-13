<?php

namespace Middle;
use Handler\RequestHandler;

interface MiddlewareInterface {
	public function process(RequestHandler $handler);
}

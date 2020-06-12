<?php

namespace Shakyou;

use Psr\Container\ContainerInterface;

abstract class Controller {
	protected string $template;
	protected array $parameters;

	protected ContainerInterface $container;

	public function __construct(array $parameters, ContainerInterface $container) {
		$this->parameters = $parameters;
		$this->container = $container;
	}

	public function head() : string {
		return "";
	}

	abstract public function title() : string;

	public function view() : string {
		return $this->template;
	}

	abstract public function action() : string;

	public function execute() {
		$this->template = $this->action();
	}
}

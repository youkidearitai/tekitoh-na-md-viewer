<?php

namespace Shakyou;

abstract class Controller {
	protected string $template;
	protected array $parameters;

	public function __construct(array $parameters) {
		$this->parameters = $parameters;
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

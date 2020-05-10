<?php

namespace Shakyou;

abstract class Controller {
	protected string $template;
	protected array $parameters;

	public function __construct(array $parameters) {
		$this->parameters = $parameters;
	}

	abstract public function title() : string;

	public function view() : string {
		return $this->template;
	}

	abstract public function action(string $contents) : string;

	public function execute(string $contents) {
		$this->template = $this->action($contents);
	}
}

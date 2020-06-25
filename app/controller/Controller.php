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

	public function mdLists(): array {
		return array_map(
			function ($file) {
				$path = \basename($file);
				$match = \sscanf($path, "%s.md");
				return ['path' => $path, 'match' => $match, 'basename' => $match[0]];
			},
			\glob(MARKDOWN_PATH . '*.md')
		);
	}
}

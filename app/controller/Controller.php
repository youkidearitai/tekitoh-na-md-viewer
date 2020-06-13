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
				$match = \sscanf($path, "shakyou_dump_%d.md");
				return ['path' => $path, 'match' => $match, 'number' => $match[0]];
			},
			\glob(MARKDOWN_PATH . MARKDOWN_SHAKYOU_PREFIX . '*.md')
		);
	}
}

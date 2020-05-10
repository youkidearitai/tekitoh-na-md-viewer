<?php

namespace Shakyou;

class TopPageController extends \Shakyou\Controller {
	public function title() : string {
		return "TOP PAGE";
	}

	public function action(string $contents) : string {
		return $contents;
	}
}

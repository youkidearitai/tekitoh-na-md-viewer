<?php

namespace Shakyou;

class TextController extends \Shakyou\Controller {
	public function title() : string {
		return sprintf("Text %s", $this->parameters["basename"]);
	}

	public function action() : string {
		return readMarkdown($this->parameters["basename"]);
	}
}


<?php

namespace Shakyou;

class TextController extends \Shakyou\Controller {
	public function title() : string {
		return sprintf("Text %d", $this->parameters["number"]);
	}

	public function action() : string {
		return readMarkdown($this->parameters["number"]);
	}
}


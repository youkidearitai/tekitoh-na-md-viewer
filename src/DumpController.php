<?php

namespace Shakyou;

class DumpController extends \Shakyou\Controller {
	public function title() : string {
		return "DUMP function";
	}

	public function action() : string {
		\ob_start();
		\study_extension_dump("Original method study_extension_dump");
		\study_extension_dump($_SERVER);
		$contents = \ob_get_contents();
		\ob_end_clean();
		return "<pre>" . h($contents) . "</pre>";
	}
}


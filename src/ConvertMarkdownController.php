<?php

namespace Shakyou;

use League\HTMLToMarkdown\HtmlConverter;

class ConvertMarkdownController extends \Shakyou\Controller {
	public function title() : string {
		return "Convert Markdown";
	}

	public function action() : string {
		$input = "";
		$output = "";

		if (isset($_POST["html"])) {
			$converter = new HtmlConverter(
				array(
					'header_style' => 'atx',
					'list_item_style' => '+',
				)
			);
			$input = $_POST["html"];
			$output = $converter->convert($_POST["html"]);
		}

		return include_once TEMPLATE_PATH . "postmarkdown.html";
	}
}

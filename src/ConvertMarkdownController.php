<?php

namespace Shakyou;

class ConvertMarkdownController extends \Shakyou\Controller {
	public function title() : string {
		return "Convert Markdown";
	}

	public function action() : string {
		$input = "";
		$output = "";

		if (isset($_POST["html"])) {
			$converter = $this->container->get("html_converter");
			$input = $_POST["html"];
			$output = $converter->convert($_POST["html"]);
		}

		$twig = $this->container->get("view");

		return $twig->render("postmarkdown.html", ['input' => $input, 'output' => $output]);
	}
}

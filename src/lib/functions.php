<?php

use League\CommonMark\CommonMarkConverter;

function h($str) {
	return \htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

function parseRouteNumber(string $request, string $router) {
	$numbers = \sscanf($request, $router);
	if (\count($numbers) != 1) {
		return false;
	}

	return $numbers[0] ?? false;
}

function readMarkdown(int $num) {
	$path = MARKDOWN_PATH . MARKDOWN_SHAKYOU_PREFIX . strval($num) . '.md';

	if (!\file_exists($path)) {
		throw new NotFoundException("404 Not Found");
	}

	$contents = \file_get_contents($path);

	if (!\is_string($contents)) {
		throw new NotFoundException("404 Not Found");
	}

	$converter = new CommonMarkConverter([
		'html_input' => 'strip',
		'allow_unsafe_links' => false,
	]);

	return $converter->convertToHtml($contents);
}


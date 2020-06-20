<?php

use League\CommonMark\CommonMarkConverter;
use Error\NotFoundException;

function h($str) {
	return \htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

function parseRouteParam(string $request, string $router) {
	if ($request === $router) {
		return [];
	}

	$numbers = \sscanf($request, $router);
	if (\count($numbers) != 1) {
		return false;
	}

	return isset($numbers[0]) ? ["number" => $numbers[0]] : false;
}

function readMarkdown(string $file) {
	$path = MARKDOWN_PATH . basename($file);

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


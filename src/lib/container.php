<?php

use DI\Container;
use League\HTMLToMarkdown\HtmlConverter;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$container = new Container();

$container->set("view", function() {
	$loader = new FilesystemLoader(TEMPLATE_PATH);
	$twig = new Environment($loader);
	return $twig;
});

$container->set("html_converter", function() {
	$hc = new HtmlConverter(
		array(
			'header_style' => 'atx',
			'list_item_style' => '+',
		)
	);
	return $hc;
});

return $container;

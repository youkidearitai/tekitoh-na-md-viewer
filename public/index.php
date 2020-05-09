<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use Michelf\MarkdownExtra;

class NotFoundException extends \Exception {
}

$routes = [
	"/" => [
		"title" => "TOP PAGE",
		"view" => function ($contents) {
			return "TOP PAGE";
		},
	],
	"/text/%d" => [
		"title" => "pages",
		"view" => function($contents) {
			return $contents;
		},
	],
	"/dump" => [
		"title" => "DUMP method",
		"view" => function ($contents) {
			\ob_start();
			\study_extension_dump($_SERVER);
			$contents = \ob_get_contents();
			\ob_end_clean();
			return "<pre>" . h($contents) . "</pre>";
		},
	],
];

function parseRouteNumber(string $request, string $router) {
	$numbers = \sscanf($request, $router);
	if (count($numbers) != 1) {
		return false;
	}

	return $numbers[0];
}

function readMarkdown(int $num) {
	$path = \dirname(__DIR__) . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'markdown' . DIRECTORY_SEPARATOR . 'shakyou_dump_' . strval($num) . '.md';

	if (!\file_exists($path)) {
		return false;
	}

	$contents = \file_get_contents($path);

	if (!\is_string($contents)) {
		throw new NotFoundException("404 Not Found");
	}

	return MarkdownExtra::defaultTransform($contents);
}

function footer() {
	$markdown = <<<MD
+ [TOP PAGE](/)
+ [study_extension_dump testing](/dump)
MD;

	foreach (\glob(\dirname(__DIR__) . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'markdown' . DIRECTORY_SEPARATOR . 'shakyou_dump_*.md') as $file) {
		$path = \basename($file);
		$match = \sscanf($path, "shakyou_dump_%d.md");
		$markdown .= \sprintf("\n+ [%s](/text/%s)", $path, $match[0]);
	}

	return MarkdownExtra::defaultTransform($markdown);
}

function h($str) {
	return \htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

$page = null;
$contents = null;

foreach ($routes as $key => $val) {
	if ($key === $_SERVER["REQUEST_URI"]) {
		$page = $val;
		$contents = $val["view"]("");
		break;
	}

	$number = parseRouteNumber($_SERVER["REQUEST_URI"], $key);

	if ($number !== false) {
		$page = $val;
		$contents = $val["view"](readMarkdown($number));
		break;
	}
}

if (!isset($page, $contents)) {
	throw new NotFoundException("404 Not Found");
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo h($val["title"]); ?></title>
</head>
<body>
<?php echo $contents; ?>
<footer><?php echo footer(); ?></footer>
</body>
</html>

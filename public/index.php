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
	"/text/:number:" => [
		"title" => "pages",
		"view" => function($contents) {
			return $contents;
		},
	],
	"/dump" => [
		"title" => "DUMP method",
		"view" => function ($contents) {
			ob_start();
			study_extension_dump($_SERVER);
			$contents = ob_get_contents();
			ob_end_clean();
			return "<pre>" . h($contents) . "</pre>";
		},
	],
];

function parseRouteNumber(string $request, string $router) {
	$exploded_router = explode(":number:", rtrim($router, '/'));

	if (count($exploded_router) < 2) {
		return false;
	}
	$pos = strpos($request, $exploded_router[0]);

	$num = "";
	$long = array_map(function ($n) { return strval($n); }, range(0, 9));

	if (is_int($pos)) {
		for ($index = strlen($exploded_router[0]), $len = strlen($request); $index < $len; $index++) {
			if (in_array($request[$index], $long)) {
				$num .= $request[$index];
			} else {
				return false;
			}
		}

		return intval($num);
	}

	return false;
}

function readMarkdown(int $num) {
	$path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'markdown' . DIRECTORY_SEPARATOR . 'shakyou_dump_' . strval($num) . '.md';

	if (!file_exists($path)) {
		return false;
	}

	$contents = file_get_contents($path);

	if (!is_string($contents)) {
		throw new NotFoundException("404 Not Found");
	}

	return MarkdownExtra::defaultTransform($contents);
}

function h($str) {
	return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

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

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo h($val["title"]); ?></title>
</head>
<body>
<?php echo $contents; ?>
</body>
</html>

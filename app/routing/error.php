<?php

\set_exception_handler(function ($errorException) : void {
	$class_name = get_class($errorException);

	switch ($class_name) {
		case "NotFoundException":
			header("HTTP/1.0 404 Not Found");
			include TEMPLATE_PATH . 'error404.html';
			break;
	}
});

class NotFoundException extends \Exception {
	public function __construct($message, $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}


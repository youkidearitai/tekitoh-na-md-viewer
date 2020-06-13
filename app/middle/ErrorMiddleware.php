<?php

namespace Middle;
use Handler\RequestHandler;
use Error\NotFoundException;

class ErrorMiddleware extends BaseMiddleware {
	public function process(RequestHandler $handler) {
		try {
			$this->middle->process($handler);
		} catch (NotFoundException $e) {
			$twig = $this->container->get("view");

			if (DEBUG) {
				ob_start();
				\study_extension_dump($e);
				$exceptionDump = ob_get_clean();

				ob_start();
				\study_extension_print_backtrace();
				$exceptionBacktrace = ob_get_clean();
			}

			\header("HTTP/1.0 404 Not Found");
			echo $twig->render("error404.html", [
				'exceptionDump' => $exceptionDump,
				'exceptionBacktrace' => $exceptionBacktrace,
				'eObject' => $e,
			]);
		} catch (\Exception $e) {
			\header("HTTP/1.0 503 Service Unavailable");
			$twig = $this->container->get("view");
			echo $twig->render("error_exception.html", [
				'eObject' => $e,
			]);
		}
	}
}

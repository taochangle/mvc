<?php

namespace Core;

/**
 * Views
 *
 * PHP version 7.0
 */
class View {

	/**
	 * Render a view file
	 *
	 * @param string $view  The view file
	 * @param array $args  Associative array of data to display in the view (optional)
	 *
	 * @return void
	 */
	protected $variables = array();
	public function assign($name, $value) {
		$this->variables[$name] = $value;
	}
	public function render($view,$module) {
		extract($this->variables);
		$route = new Router();
		$file = dirname(__DIR__) . "/App/".$module."/Views/".$view.".html"; // relative to Core directory

		if (is_readable($file)) {
			require $file;
		} else {
			throw new \Exception("$file not found");
		}
	}

	/**
	 * Render a view template using Twig
	 *
	 * @param string $template  The template file
	 * @param array $args  Associative array of data to display in the view (optional)
	 *
	 * @return void
	 */
	public static function renderTemplate($template, $args = []) {
		static $twig = null;

		if ($twig === null) {
			$loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
			$twig = new \Twig_Environment($loader);
		}

		echo $twig->render($template, $args);
	}
}
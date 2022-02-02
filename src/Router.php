<?php

namespace App;

use AltoRouter;

class Router {
	private AltoRouter $router;
	private string $viewPath;

	public function __construct($viewPath)
	{
		$this->router = new Altorouter();
		$this->viewPath = $viewPath;
	}

	public function get($route, $path, $name): self
	{
		$view = $this->viewPath . DIRECTORY_SEPARATOR . str_replace('.', '/', $path) . '.php';
		$this->router->map('GET', $route, $view, $name);
		return $this;
	}

	public function url(string $url, array $params = [])
	{
		return $this->router->generate($url, $params);
	}

	public function run()
	{
		$router = $this;
		$match = $this->router->match();
		if($match !== false && $match !== null) {
			$view = $match['target'];
			$params = $match['params'];
		}
		else
		{
			$view = $this->viewPath . DIRECTORY_SEPARATOR . 'main/e404.php';
		}
		ob_start();
		require $view;
		$pageContent = ob_get_clean();
		require $this->viewPath . DIRECTORY_SEPARATOR . 'layouts/default.php'; 
	}
}
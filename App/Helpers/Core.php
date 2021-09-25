<?php

namespace App\Helpers;

use Twig\Environment;

class Core
{
	public function view(string $path, array $params = []): void
	{
		echo  $this->components('Environment')->render($path, $params);
	}

	public function components(string $name)
	{
		global $app;
		return $app->get($name);
	}

}
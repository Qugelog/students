<?php

namespace App\Helpers;

class Core
{
	public static function view(string $path, array $params = []): void
	{
		echo  self::components('Twig')->render($path, $params);
	}

	public static function components(string $name)
	{
		global $app;
		return $app->get($name);
	}

}
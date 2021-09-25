<?php

function view(string $path, array $params = []): void
{
	echo components('Twig')->render($path, $params);
}

function components(string $name)
{
	global $container;
	return $container->get($name);
}

function config($field)
{
	$config = require '../config/config.php';
	return \App\Helpers\Arr::get($config, $field);
}

function back()
{
	header("Location: " . $_SERVER['HTTP_REFERER']);
	exit;
}

function redirect($path)
{
	header("Location: $path");
	exit;
}
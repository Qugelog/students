<?php

use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

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

function validateStringField(string $field,  $minLength = null,  $maxLength = null, string $message = 'Данные заполнены неверно!')
{
	try
	{
		$validator = v::key($field, v::stringType()->notEmpty()->length($minLength, $maxLength));
		$validator->assert($_POST);
	} catch (ValidationException $exception)
	{
		$flasher = components('Flasher');
		$flasher->error($message);

		return back();
	}
}

function validateNum(string $field,  $min = null,  $max = null, string $message = 'Данные заполнены неверно!')
{
	try
	{
		$validator = v::key($field, v::intVal()->between($min, $max)->notEmpty());
		$validator->assert($_POST);
	} catch (ValidationException $exception)
	{
		$flasher = components('Flasher');
		$flasher->error($message);

		return back();
	}
}
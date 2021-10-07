<?php

return [
	'TwigLoader' => Di\factory(function () {
		return new Twig\Loader\FilesystemLoader('../App/Views/');
	}),
	'Twig' => DI\factory(function (\Psr\Container\ContainerInterface $c) {
		return new Twig\Environment($c->get('TwigLoader'));
	}),
	'PDO' => DI\factory(function (\Psr\Container\ContainerInterface $c) {
		$driver = config('db.driver');
		$host = config('db.host');
		$dbname = config('db.dbname');
		$username = config('db.username');
		$password = config('db.password');

		return new PDO($driver . ':host=' . $host . ';dbname=' . $dbname, $username, $password);
	}),
	\Aura\SqlQuery\QueryFactory::class => function() {
		return new \Aura\SqlQuery\QueryFactory('mysql');
	},
	'Flasher' => DI\factory(function () {
		return new \Plasticbrain\FlashMessages\FlashMessages();
	})
];
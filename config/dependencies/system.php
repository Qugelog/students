<?php

return [
	'TwigLoader' => Di\factory(function () {
		return new Twig\Loader\FilesystemLoader('../App/Views/');
	}),
	'Twig' => DI\factory(function (\Psr\Container\ContainerInterface $c) {
		$twig = new Twig\Environment($c->get('TwigLoader'));
		return $twig;
	}),
	'PDO' => DI\factory(function (\Psr\Container\ContainerInterface $c) {
		$data = $c->get('db');

		return new PDO($data['driver'] . ':host=' . $data['host'] . ';dbname=' . $data['dbname'], $data['username'], $data['password']);
	}),
	'QueryFactory' => DI\factory(function () {
		$sql = new \Latitude\QueryBuilder\QueryFactory(new \Latitude\QueryBuilder\Engine\CommonEngine());
		return $sql;
	})
];
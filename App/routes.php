<?php

use App\Controllers\MainController;



$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions([
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
]);

$container = $containerBuilder->build();


$dispatcher = FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {

	// Main
	$r->get('/', ['App\Controllers\MainController', 'index']);

	// Groups
	$r->get('/groups', ['App\Controllers\GroupController', 'show']);
	$r->get('/groups/add', ['App\Controllers\GroupController', 'addForm']);
	$r->get('/groups/{id: \d+}/edit', ['App\Controllers\GroupController', 'edit']);
	$r->get('/groups/{id: \d+}/remove', ['App\Controllers\GroupController', 'remove']);

	$r->post('/groups/{id: \d+}/update', ['App\Controllers\GroupController', 'update']);
	$r->post('/groups/store', ['App\Controllers\GroupController', 'store']);

	// Students
	$r->get('/students', ['App\Controllers\StudentController', 'show']);
	$r->get('/students/add', ['App\Controllers\StudentController', 'addForm']);
	$r->get('/students/{id: \d+}/edit', ['App\Controllers\StudentController', 'edit']);
	$r->get('/students/{id: \d+}/remove', ['App\Controllers\StudentController', 'remove']);

	$r->post('/students/{id: \d+}/update', ['App\Controllers\StudentController', 'update']);
	$r->post('/students/store', ['App\Controllers\StudentController', 'store']);

	// Subjects
	$r->get('/subjects', ['App\Controllers\SubjectController', 'show']);
	$r->get('/subjects/add', ['App\Controllers\SubjectController', 'addForm']);
	$r->get('/subjects/{id: \d+}/edit', ['App\Controllers\SubjectController', 'edit']);
	$r->get('/subjects/{id: \d+}/remove', ['App\Controllers\SubjectController', 'remove']);

	$r->post('/subjects/{id: \d+}/update', ['App\Controllers\SubjectController', 'update']);
	$r->post('/subjects/store', ['App\Controllers\SubjectController', 'store']);

	// Socres
	$r->get('/scores', ['App\Controllers\ScoreController', 'show']);
	$r->get('/scores/add', ['App\Controllers\ScoreController', 'addForm']);
	$r->get('/scores/{id: \d+}/edit', ['App\Controllers\ScoreController', 'edit']);
	$r->get('/scores/{id: \d+}/remove', ['App\Controllers\ScoreController', 'remove']);

	$r->post('/scores/{id: \d+}/update', ['App\Controllers\ScoreController', 'update']);
	$r->post('/scores/store', ['App\Controllers\ScoreController', 'store']);
});



// Получаем метод запроса и сам URL
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Проверяем, есть ли GET параметры
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
// Декодируем URL
$uri = rawurldecode($uri);

// Берём информацию о роутинге
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
// Проверяем
switch ($routeInfo[0]) {
	// Если нет страницы
	case FastRoute\Dispatcher::NOT_FOUND:
		echo '404';
		break;

	// Если нет метода для обработки
	case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
		$allowedMethods = $routeInfo[1];
		// ... 405 Нет метода
		break;

	// Если всё нашлось
	case FastRoute\Dispatcher::FOUND:

		$handler = $routeInfo[1];
		$vars = $routeInfo[2];

		$container->call($handler, $vars);
		break;
}
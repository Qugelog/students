<?php

use App\Controllers\MainController;

global $container;


$dispatcher = FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
	$r->get('/', ['\App\Controllers\MainController', 'index']);
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
		// ... 404 Не найдена страница
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
<?php

namespace App\Controllers;

use App\Helpers\Core;
use App\Services\Database;
use Aura\SqlQuery\QueryFactory;
use PDO;
use Twig\Environment;

class Controller
{
	protected $view;
	protected $database;
	protected $flasher;
	protected $queryFactory;
	protected $pdo;

	public function __construct()
	{
		$this->database = components(Database::class);
		$this->view = components('Twig');
		$this->flasher = components('Flasher');
		$this->queryFactory = components(QueryFactory::class);
		$this->pdo = components(PDO::class);
	}


}
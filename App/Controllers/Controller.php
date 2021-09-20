<?php

namespace App\Controllers;

use App\Helpers\Core;
use App\Services\Database;

class Controller
{
	protected $view;
	protected $database;

	public function __construct()
	{
		$this->view = Core::components('Twig');
		$this->database = Core::components(Database::class);
	}


}
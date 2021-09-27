<?php

namespace App\Controllers;

use App\Services\Database;

 class MainController extends Controller
{
	public function index()
	{
		echo $this->view->render('index.twig');
	}

}
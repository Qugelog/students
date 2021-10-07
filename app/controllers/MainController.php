<?php

namespace App\Controllers;


 class MainController extends Controller
{
	public function index()
	{
		echo $this->view->render('index.twig');
	}

}
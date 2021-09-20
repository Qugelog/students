<?php

namespace App\Controllers;

use App\Helpers\Core;

class MainController extends Controller
{
	public function index()
	{
		Core::view('index.html');
	}

}
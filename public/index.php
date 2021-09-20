<?php
use App\Helpers;
use App\Helpers\Core;


require_once  '../vendor/autoload.php';
$app = require '../bootstrap/container.php';
require_once  '../App/routes.php';

echo "<pre>";
var_dump($app);
echo "</pre>";



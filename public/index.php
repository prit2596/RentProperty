<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

require_once('../app/api/users.php');
require_once('../app/api/login.php');
require_once('../app/api/register.php');
require_once('../app/api/property.php');
require_once('../app/api/rent.php');

$app->run();
?>

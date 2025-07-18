<?php

require_once __DIR__ . '/../app/core/autoload.php';
require_once __DIR__ . '/../app/core/Router.php';

$router = new Router();
$router->run();
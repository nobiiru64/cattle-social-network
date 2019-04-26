<?php

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'/..');
$dotenv->load();

$functions = require_once __DIR__.'/../app/functions.php';

$app = new Nobiiru\App();
require '../routes/web.php';
$app->run();




<?php

// start session for authorization and accounting system messages
session_start();

// the base path to the application
define('ROOT_PATH', rtrim($_SERVER['DOCUMENT_ROOT'], '/\\'));

// path to system folder
define('SYSTEM_PATH', ROOT_PATH . '/system');

// path to the folder with controllers
define('CONTROLLERS_PATH', ROOT_PATH . '/controllers');

// path to the folder with the models
define('MODELS_PATH', ROOT_PATH . '/models');

// path to the folder with the views
define('VIEWS_PATH', ROOT_PATH . '/views');

// path to the folder with templates
define('TEMPLATES_PATH', ROOT_PATH . '/templates');

// path to the folder with static data
define('STATIC_PATH', ROOT_PATH . '/static');

// connection kernel
include_once SYSTEM_PATH . '/core.php';

// kernel initialization
$core = new Core();

// reading config
$core->config = parse_ini_file(SYSTEM_PATH . '/config.ini');

// launch
$core->start();

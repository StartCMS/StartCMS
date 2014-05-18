<?php

// start session for authorization and accounting system messages
session_start();

// the base path to the application
define( 'root', rtrim( $_SERVER['DOCUMENT_ROOT'], '/\\' ) );

// path to system folder
define( 'system_dir', root. '/system' );

// path to the folder with controllers
define( 'controllers_dir', root. '/controllers' );

// path to the folder with the models
define( 'models_dir', root. '/models' );

// path to the folder with the views
define( 'views_dir', root. '/views' );

// path to the folder with templates
define( 'templates_dir', root. '/templates' );

// path to the folder with static data
define( 'static_dir', root. '/static' );

// connection kernel
include_once system_dir.'/core.php';

// kernel initialization
$core = new Core();

// reading config
$core->config = parse_ini_file(system_dir . '/config.ini');

// launch
$core->start();
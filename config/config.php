<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 07/10/2023
 * Time: 02:54 PM
 */

/*
 * PHP settings
 */
session_start();
date_default_timezone_set('Africa/Lagos');
ini_set('display_errors', 'On');
ob_start("ob_gzhandler");
error_reporting(E_ALL);
ini_set('max_execution_time', 0);

/*
 * Application Root Directory Setup
 */
$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = $_SERVER['DOCUMENT_ROOT'];
$webRoot = str_replace(array($docRoot, 'config/config.php'), '', $thisFile);
$srvRoot = str_replace('config/config.php', '', $thisFile);

define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);


//Database configuration path
define('DB_CONFIG', __DIR__ . '../../config/db_config.ini');


//Views Path
define('VIEWS', __DIR__ . '../../views/');
define('STORE_VIEWS', __DIR__ . '../../views/store/');
define('ADMIN_VIEWS', __DIR__ . '../../views/admin/');

//Application Menus Directory
define('MENU_DIR', __DIR__ . '../../src/Menu/');


/*
 * Resource Directories Path
 */

define('ASSETS', WEB_ROOT . 'assets/');
define('APP_ASSETS', WEB_ROOT . 'app-assets/');
define('PLUGINS', WEB_ROOT . 'plugins/');

//Redirection Path
define('DASHBOARD', '/admin');
define('ADMIN_LOGIN', DASHBOARD . '/login');
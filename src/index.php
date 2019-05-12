<?php
session_start();

// PHP Includes
// ---------------------------------------------------------------------
require_once __DIR__."/models/SimpleSQL.php";
require_once __DIR__."/models/SimpleORM.php";

require_once __DIR__."/models/User.php";
require_once __DIR__."/lib/SimpleTable.php";

// Handle Routing
// ---------------------------------------------------------------------
if(isset($_GET['controller']) && isset($_GET['action']) ) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else {
    $controller = 'pages';
    $action = 'overview';
}

// Handle Login
// ---------------------------------------------------------------------
if(!isset($_SESSION['login_user']) and $controller != 'user' and $action != 'login') {
    $controller = 'pages';
    $action = 'login';
    $_GET['error'] = '';
}

require_once(__DIR__.'/views/layout.php');
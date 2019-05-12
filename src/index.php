<?php
session_start();

// Add configs and non-class libs
// ---------------------------------------------------------------------
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/lib/HtmlBuilder.php';

// Register Autoload for classes
// ---------------------------------------------------------------------
spl_autoload_register(function ($class) {
    $directories = [
        'lib/' => '.php',
        'models/' => '.php',
        'controllers/' => '.php',
        'views/' => '.php'
    ];

    foreach ($directories as $directory => $fileAppend) {
        $filePath = __DIR__ . '/' . $directory . $class . $fileAppend;
        if (file_exists($filePath)) {
            require_once $filePath;
            return;
        }
    }
});

// Handle Routing
// ---------------------------------------------------------------------
if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else {
    $controller = 'pages';
    $action = 'overview';
}

// Handle Login
// ---------------------------------------------------------------------
if (!isset($_SESSION['login_user']) and $controller != 'user' and $action != 'login') {
    $controller = 'pages';
    $action = 'login';
    $_GET['error'] = '';
}

require_once(__DIR__ . '/layout.php');
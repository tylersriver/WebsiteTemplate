<?php

/**
 * Step 1.
 *
 * Start Session
 *
 * This has to be done at entry point.
 * used for managing logged in user
 */
session_start();

/**
 * Step 2.
 *
 * Config and Requires
 *
 * Require the needed configs not stored in GIT
 * and all files that can't be autoloaded
 */
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/lib/view-utils/HtmlBuilder.php';

/**
 * Step 3.
 *
 * Autoload
 *
 * Register the autoloader for finding classes
 * in the application
 *
 * Whitelist directories to minimize searching
 */
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

/**
 * Step 4.
 *
 * Verify Route
 *
 * Validate the action and controller coming from the _GET
 * array. Default homepage if none given.
 */
if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else {
    $controller = 'pages';
    $action = 'overview';
}

/**
 * Step 5.
 *
 * Verify user is logged in
 *
 * TODO: Make security stronger, maybe add cookie
 */
if (!isset($_SESSION['login_user'])
    and $controller != 'user'
    and $action != 'login'
) {
    $controller = 'pages';
    $action = 'login';
    $_GET['error'] = '';
}

/**
 * Step 6.
 *
 * Output View
 *
 * Here we build the base portion of the site
 *      * Header -> CSS Includes
 *      * Body -> Navbar and *Route Action*
 *      * Footer -> End Page
 *      * JS Includes
 */
echo
h('html',
    h('head',
        // -- CSS Includes --
        h('link', [
            'rel' => 'stylesheet',
            'href' => 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
            'integrity' => 'sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm',
            'crossorigin' => 'anonymous'
        ]),
        h('link', [
            'rel' => 'stylesheet',
            'href' => 'views/styles/global-styles.css'
        ])
    ),
    h('body',

        // -- Nav Bar --
        h('nav.navbar.navbar-expand-lg.navbar-dark.bg-dark',
            h('a.navbar-brand', ['href' => '#'], 'Website Template'),
            h('button.navbar-toggler', [
                'type' => 'button',
                'data-toggle' => 'collapse',
                'data-target' => '#navbarSupportedContent',
                'aria-controls' => 'navbarSupportedContent',
                'aria-expanded' => 'false',
                'aria-label' => 'Toggle navigation'
            ], h('span.navbar-toggler-icon')),
            h('div.collapse.navbar-collapse', ['id' => 'navbarSupportedContent'],
                h('ul.navbar-nav.mr-auto',
                    h('li.nav-item', h('a.nav-link', ['href'=>'?'], 'Home', h('span.sr-only', '(current)'))),
                    h('li.nav-item.dropdown',
                        h('a.nav-link.dropdown-toggle', [
                            'href' => '#',
                            'id' => 'navbarDropdownMenuLink',
                            'role' => 'button',
                            'data-toggle' => 'dropdown',
                            'aria-haspopup' => 'true',
                            'aria-expanded' => 'false'
                        ], 'Profile') ,
                        h('div.dropdown-menu', ['aria-labelledby' => 'navbarDropdownMenuLink'],
                            h('a.dropdown-item', ['href' => '?controller=pages&action=login'], 'Login'),
                            h('a.dropdown-item', ['href' => '?controller=user&action=logout'], 'Logout')
                        )
                    )
                )
            )
        ),

        // -- Route Action --
        Router::Call($controller, $action),

        // -- Footer --
        h('footer',
            h('div.footer', 'Copyright Tyler Sriver | 2018 | ', h('a', ['href' => 'https://github.com/tylersriver/'], 'GitHub Repo'))
        ),

        // -- JS Scripts --
        h('script', [
            'src' => 'https://code.jquery.com/jquery-3.2.1.slim.min.js',
            'integrity' => 'sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN',
            'crossorigin' => 'anonymous'
        ]),
        h('script', [
            'src' => 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
            'integrity' => 'sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q',
            'crossorigin' => 'anonymous'
        ]),
        h('script', [
            'src' => 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',
            'integrity' => 'sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl',
            'crossorigin' => 'anonymous'
        ])
    )
);
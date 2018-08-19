<?php 

/**
 * Calls the associated action from the controller
 * 
 * @param string $controller
 * @param string $action
 */
function call($controller, $action)
{
    require_once('php/controllers/' . $controller . '.controller.php');

    switch($controller) {
      case 'pages':
        $controller = new PagesController();
        break;
      case 'user':
        $controller = new UserController();
        break;
    }

    $controller->{ $action }();
}

  // we're adding an entry for the new controller and its actions
  $controllers = array(
    'pages' => [
      'overview', 
      'error',
      'login'
    ],
    'user' => [
      'login',
      'logout'
    ]
  );

  // Handling calling the controller
  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('pages', 'error');
    }
  } else {
    call('pages', 'error');
  }
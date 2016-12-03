<?php

session_start();

require 'vendor/autoload.php';
require 'app/controllers/PageController.php';

// define the file root of the parent folder
define( 'APPROOT', dirname(__FILE__) . '/' );

// location the config file
require (APPROOT . '../confin.inc.php');
// connect to the database
$dbc  = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// test connection
if ($dbc->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//get the page request
$page = isset($_GET['page']) ? $_GET['page'] : 'landing';

//Run the switch
switch ($page) {

	case 'landing':
		require 'app/controllers/LandingController.php';
		$controller = new LandingController($dbc);
	break;

  case 'register':
    require 'app/controllers/RegisterController.php';
    $controller = new RegisterController($dbc);
  break;

	case 'login':
		require 'app/controllers/LoginController.php';
		$controller = new LoginController($dbc);
	break;

  case 'logout':
    require 'app/controllers/LogoutController.php';
    $controller = new LogoutController($dbc);
  break;

  case 'ask':
    require 'app/controllers/AskController.php';
    $controller = new AskController($dbc);
  break;

  case 'question':
    require 'app/controllers/QuestionController.php';
    $controller = new QuestionController($dbc);
  break;

  case 'search':
    require 'app/controllers/searchController.php';
    $controller = new searchController($dbc);
  break;

  case 'error':
    require 'app/controllers/errorController.php';
    $controller = new errorController($dbc);
  break;

}


$controller->buildHTML();

<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('controller/LoginController.php');

use view\LoginView;
use view\DateTimeView;

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$loginM = new \model\LoginModel();
$loginV = new LoginView($loginM);
$dateTimeV = new DateTimeView();

$loginC = new \control\LoginController($loginM, $loginV);
$lv = new LayoutView();

$loggedIn = $loginC->doLogin();

$lv->render($loggedIn, $loginV, $dateTimeV);


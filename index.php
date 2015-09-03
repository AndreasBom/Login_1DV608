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
$loginC = new \control\LoginController($loginM);

$loginV = new LoginView($loginM);
$dateTimeV = new DateTimeView();

$lv = new LayoutView();

$loginC->doLogin();
$lv->render(false, $loginV, $dateTimeV);


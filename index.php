<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/LoginModel.php');
require_once('controller/LoginController.php');
require_once('helpers/config.php');
require_once('view/CookieStorage.php');
require_once('model/AutoLogin.php');

use \controller\LoginController;

new \helpers\config();

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();
session_regenerate_id();

//CREATE OBJECTS OF THE VIEWS
$loginM = new \model\LoginModel();
$v = new LoginView($loginM);
$dtv = new DateTimeView();
$lv = new LayoutView();

$loginC = new LoginController($loginM);
$loggedInSuccessfully = $loginC->doLogin();

$lv->render($loggedInSuccessfully, $v, $dtv);


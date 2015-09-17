<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
<<<<<<< HEAD
<<<<<<< HEAD
require_once('model/LoginModel.php');
require_once('controller/LoginController.php');
require_once('helpers/config.php');
require_once('view/CookieStorage.php');

use \controller\LoginController;

new \helpers\config();
=======
=======
>>>>>>> Branch2
require_once('controller/LoginController.php');

use view\LoginView;
use view\DateTimeView;
<<<<<<< HEAD
>>>>>>> origin/master
=======
use \control\LoginController;
>>>>>>> Branch2

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();
<<<<<<< HEAD
session_regenerate_id();

//CREATE OBJECTS OF THE VIEWS
<<<<<<< HEAD
$loginM = new \model\LoginModel();
$v = new LoginView($loginM);
$dtv = new DateTimeView();
$lv = new LayoutView();

$loginC = new LoginController($loginM);
$loggedInSuccessfully = $loginC->doLogin();

$lv->render($loggedInSuccessfully, $v, $dtv);
=======

//CREATE OBJECTS OF THE VIEWS
$loginM = new \model\LoginModel();
$loginV = new LoginView($loginM);
$dateTimeV = new DateTimeView();

$loginC = new \control\LoginController($loginM);
$lv = new LayoutView();

$loggedIn = $loginC->doLogin();
>>>>>>> origin/master

$lv->render($loggedIn, $loginV, $dateTimeV);
=======
//$model = new \model\LoginModel();
//$v = new LoginView($model);
//$dtv = new DateTimeView();
//
//$lv = new LayoutView();
//
//
//
//$lv->render(false, $v, $dtv);
//////////////

$loginC = new LoginController();
$loginV = new LoginView();
$layoutV = new LayoutView();
$dateTimeV = new DateTimeView();

$layoutV->render(false, $loginV, $dateTimeV);
>>>>>>> Branch2

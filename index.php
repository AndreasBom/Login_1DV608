<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('controller/LoginController.php');

use view\LoginView;
use view\DateTimeView;
use \control\LoginController;

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
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

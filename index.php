<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

use view\LoginView;
use view\DateTimeView;

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$model = new \model\LoginModel();
$v = new LoginView($model);
$dtv = new DateTimeView();

$lv = new LayoutView();



$lv->render(false, $v, $dtv);


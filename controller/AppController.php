<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-01
 * Time: 10:41
 */

namespace controller;

//INCLUDE THE FILES NEEDED...
use view\RegisterView;

require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/LoginModel.php');
require_once('controller/LoginController.php');
require_once('view/CookieStorage.php');
require_once('model/AutoLogin.php');
require_once('exception/InvalidCookieExceptionException.php');
require_once('view/RegisterView.php');
require_once('model/RegisterModel.php');
require_once('controller/RegisterController.php');



class AppController
{


    public function run()
    {

        //CREATE OBJECTS OF THE VIEWS
        $loginM = new \model\LoginModel();
        $dtv = new \view\DateTimeView();
        $layoutV = new \view\LayoutView();
        $registerM = new \model\RegisterModel();

        $registerV = new \view\RegisterView();
        $loginC = new LoginController($loginM);
        $registerC = new \controller\RegisterController($registerM, $registerV);
        $loggedInSuccessfully = false;




        if($layoutV->didUserPressRegistrationLink())
        {
            $lv = $registerV;
            $registerC->doRegister();

        }
        else
        {
            $lv = new \view\LoginView($loginM);
            $loggedInSuccessfully = $loginC->doLogin(); //returns bool
        }

        $layoutV->render($loggedInSuccessfully, $lv, $dtv);


    }






}
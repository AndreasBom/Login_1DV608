<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-09-16
 * Time: 21:18
 */

namespace controller;


use model\LoginModel;

class LoginController
{
    private $loginmodel;
    private $loginview;

    public function __construct(LoginModel $model)
    {
        $this->loginmodel = $model;
        $this->loginview = new \LoginView($model);
    }

    public function doLogin()
    {
        $submitedUsername = $this->loginview->getUsername();
        $submitedPassword = $this->loginview->getPassword();

        if($this->loginview->didUserTryToLoggin())
        {
            $this->loginmodel->evaluateUserCredentials($submitedUsername, $submitedPassword);
            $this->loginmodel->setUsernameInSession($submitedUsername);
            $this->loginview->showMessage($this->loginmodel->isUserLoggedIn());
        }

        if($this->loginview->didUserLogout())
        {
            $this->loginmodel->logoutUser();
            $this->loginview->showMessage($this->loginmodel->isUserLoggedIn());
        }


        return $this->loginmodel->isUserLoggedIn();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-09-16
 * Time: 21:18
 */

namespace controller;


use model\autoLogin;
use model\LoginModel;

class LoginController
{
    private $loginModel;
    private $loginView;
    private $autoLogin;

    public function __construct(LoginModel $model)
    {
        $this->loginModel = $model;
        $this->loginView = new \LoginView($model);
        $this->autoLogin = new autoLogin($model);
    }


    public function doLogin()
    {
        $submitedUsername = $this->loginView->getUsername();
        $submitedPassword = $this->loginView->getPassword();

        if($this->loginView->loginWithSavesCredentials())
        {
            $usernameInCookie = $this->loginView->getSavedUsername();
            $passwordString = $this->loginView->getSavedPasswordString();

            //
            $this->autoLogin->evaluateSavedCredentials($usernameInCookie, $passwordString);


        }

        if($this->loginView->didUserTryToLoggin())
        {
            $this->loginModel->evaluateUserCredentials($submitedUsername, $submitedPassword);
            $this->loginModel->setUsernameInSession($submitedUsername);
            $this->loginView->showMessage($this->loginModel->isUserLoggedIn());

            if($this->loginModel->isUserLoggedIn() && $this->loginView->rememberMe())
            {
                //generate and saves random passwordstring at server
                $passwordString = $this->autoLogin->generatePasswordString($submitedUsername);
                //Saves username and passwordstring to cookie
                $this->loginView->saveCredentials($submitedUsername, $passwordString);
            }

        }

        if($this->loginView->didUserLogout())
        {
            $this->loginModel->logoutUser();
            $this->loginView->deleteCredentials();
            $this->loginView->showMessage($this->loginModel->isUserLoggedIn());
        }




        return $this->loginModel->isUserLoggedIn();
    }
}
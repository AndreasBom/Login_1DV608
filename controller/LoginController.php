<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-09-16
 * Time: 21:18
 */

namespace controller;


use exception\InvalidCookieException;
use model\AutoLogin;
use model\Identifier;
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
        $this->autoLogin = new AutoLogin($model);
    }


    public function doLogin()
    {
        $submitedUsername = $this->loginView->getUsername();
        $submitedPassword = $this->loginView->getPassword();
        $userIp = $this->loginView->getUserIp();
        $userBrowser = $this->loginView->getUserBrowser();

        if($this->loginView->loginWithSavedCredentials())
        {

                $usernameInCookie = $this->loginView->getSavedUsername();
                $passwordString = $this->loginView->getSavedPasswordString();

                try
                {
                    $this->autoLogin->evaluateSavedCredentials($usernameInCookie, $passwordString);
                }
                catch (\Exception $e)
                {
                    throw new \exception\InvalidCookieException();
                }




                $this->loginView->showMessage($this->loginModel->isUserLoggedIn());



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
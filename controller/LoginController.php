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
        //Saves provided username and password to varibles
        $submitedUsername = $this->loginView->getUsername();
        $submitedPassword = $this->loginView->getPassword();

        //If cookes with username and password exists
        if($this->loginView->loginWithSavedCredentials())
        {
                //Fetches username and passwordstring from cookie
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

        //If user presses login button
        if($this->loginView->didUserTryToLoggin())
        {
            //check if username and password is correct
            $this->loginModel->evaluateUserCredentials($submitedUsername, $submitedPassword);
            //Saves provided username in session. This is used to autocomplete form with username
            $this->loginModel->setUsernameInSession($submitedUsername);
            $this->loginView->showMessage($this->loginModel->isUserLoggedIn());

            //Login and remember me
            if($this->loginModel->isUserLoggedIn() && $this->loginView->rememberMe())
            {
                //generate and saves random passwordstring at server
                $passwordString = $this->autoLogin->generatePasswordString($submitedUsername);
                //Saves username and passwordstring to cookie
                $this->loginView->saveCredentials($submitedUsername, $passwordString);

            }

        }

        //If user presses logout button
        if($this->loginView->didUserLogout())
        {
            $this->loginModel->logoutUser();
            $this->loginView->deleteCredentials();

            $this->loginView->showMessage($this->loginModel->isUserLoggedIn());
        }

        //returns bool; is user logged in?
        return $this->loginModel->isUserLoggedIn();
    }
}
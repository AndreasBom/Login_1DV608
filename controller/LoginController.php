<?php
/**
 * Created by PhpStorm.
 * User: Andreas
<<<<<<< HEAD
 * Date: 2015-09-16
 * Time: 21:18
 */

namespace controller;


use model\AutoLogin;
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




<<<<<<< HEAD
        return $this->loginModel->isUserLoggedIn();
=======
        return $this->loginmodel->isUserLoggedIn();
=======
 * Date: 2015-08-31
 * Time: 13:20
 */

namespace control;

use model\LoginModel;
use view\LoginView;

class LoginController
{
    private $loginModel;
    private $loginView;

    public function __construct(LoginModel $model)
    {
        $this->loginModel = $model;
        $this->loginView = new LoginView($model);
    }

    /**
     * Checks if user name and password is correct
     * Updates loginMessage
     *
     *
     * @return bool is User logged in?
     */
    public function doLogin()
    {
        if($this->loginView->didUserTryToLogin())
        {
            $this->loginModel->evaluateUserCredidentionals($this->loginView->getUsername(), $this->loginView->getPassword());
            $this->loginView->showLoginMessage($this->loginModel->isUserLoggedIn());
        }

        if($this->loginView->didUserTryToLogout())
        {
            $this->loginModel->logoutUser();
            $this->loginView->showLoginMessage(false);
        }


        return $this->loginModel->isUserLoggedIn();
>>>>>>> origin/master
>>>>>>> 06f2d2fa6b9544548e570506b1f9ab8342f191ed
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Andreas
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
    }
}
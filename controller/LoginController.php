<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-08-31
 * Time: 13:20
 */

namespace control;

use model\LoginModel;
use view\CookieStorage;
use view\LoginView;

class LoginController
{
    private $loginModel;
    private $loginView;

    public function __construct(LoginModel $model, LoginView $loginView)
    {
        $this->loginModel = $model;
        $this->loginView = $loginView;
    }

    public function doLogin()
    {
        if($this->loginView->didUserTryToLogin()) {
            $loggedIn = $this->loginModel->correctLoginCredidentials($this->loginView->getUsername(), $this->loginView->getPassword());
            $this->loginView->showLoginMessage($loggedIn);
            $this->generateView();
            return ($loggedIn);
        }

        $this->generateView();
        return false;
    }

    private function generateView(){
        $this->loginView->response();
    }
}
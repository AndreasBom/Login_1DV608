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

    public function doLogin()
    {

        if($this->loginView->didUserTryToLogin()) {
            header("Location: " . $_SERVER["PHP_SELF"]);
            $this->loginModel->correctLoginCredidentials($this->loginView->getUsername(), $this->loginView->getPassword());
            $message= $this->loginModel->generateResponseMessage();

        }


        return $this->loginView->response();
    }
}
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
    private $cookieStorage;

    public function __construct(LoginModel $model)
    {
        $this->loginModel = $model;
        $this->loginView = new LoginView($model);
        $this->cookieMessage = new CookieStorage();
    }

    public function doLogin()
    {

        if($this->loginView->didUserTryToLogin()) {

            $this->loginModel->correctLoginCredidentials($this->loginView->getUsername(), $this->loginView->getPassword());

        }
        $message= $this->loginModel->generateResponseMessage();
        $this->cookieMessage->save("message", $message);


        return $this->loginView->response();
    }
}
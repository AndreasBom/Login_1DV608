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
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new LoginModel();
        $this->view = new LoginView($this->model);
    }

    public function doLogin()
    {
        $username = $this->view->getUserName();
        $password = $this->view->getPassword();

        if($this->view->didUserTryToLogin()){
            if($this->model->correctLoginCredidentials(trim($username), $password)){
                $this->model->login();
            }

        }

        return $this->view->response();
    }
}
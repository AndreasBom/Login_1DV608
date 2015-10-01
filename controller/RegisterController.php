<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-01
 * Time: 13:42
 */

namespace controller;


use model\NotValidPasswordException;
use model\NotValidUserNameException;
use model\PasswordDoNotMatchException;
use model\NotUniqueUserNameException;
use model\RegisterModel;
use model\UserNameContainingHTMLTagException;
use view\RegisterView;

class RegisterController
{
    private $model;
    private $regView;

    public function __construct(RegisterModel $model, RegisterView $regView)
    {
        $this->model = $model;
        $this->regView = $regView;
    }

    public function doRegister()
    {

        if($this->regView->didUserTryToRegister())
        {
            $userName = $this->regView->getUsername();
            $password = $this->regView->getPassword();
            $repeatPassword = $this->regView->getRepeatPassword();

            $this->validateInput($userName, $password, $repeatPassword);


        }


    }

    private function validateInput($userName, $password, $repeatPassword)
    {
        try
        {
            $message= '';
            try
            {
                $this->model->validateUsername($userName);
            }
            catch (NotValidUserNameException $ex)
            {
                $message = "Username has too few characters, at least 3 characters.<br/>";
            }
            try
            {
                $this->model->validatePassword($password);
            }
            catch (NotValidPasswordException $ex)
            {
                $message .= "Password has too few characters, at least 6 characters.<br/>";
            }
            try
            {
                $this->model->validateRepetedPassword($password, $repeatPassword);
            }
            catch(PasswordDoNotMatchException $ex)
            {
                $message .= "Passwords do not match.<br/>";
            }
            try
            {
                $this->model->UserNameisUnique($userName);
            }
            catch(NotUniqueUserNameException $ex)
            {
                $message .= "User exists, pick another username.";
            }
            try
            {
                $this->model->validateNoHtmlTags($userName);
            }
            catch (UserNameContainingHTMLTagException $ex)
            {
                $message .= "Username contains invalid characters.";
            }
        }
        finally
        {
            $this->regView->message($message);
        }
    }



}
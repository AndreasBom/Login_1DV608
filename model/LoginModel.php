<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-08-31
 * Time: 13:17
 */

namespace model;



class LoginModel
{
    //dummy data
    private static $userName = "Admin";
    private static $password = "Password";
    private static $sessionLocation = "LoginModel::LoggedIn";
    private $isUserLoggedIn = false;

    private function saveToSession(){
        $_SESSION[self::$sessionLocation] = $this->isUserLoggedIn;
    }

    public function IsUserLoggedIn(){
        return $_SESSION[self::$sessionLocation];
    }



    public function correctLoginCredidentials($userName, $password)
    {
        if(self::$userName == trim($userName) && self::$password == trim($password)){
            $this->isUserLoggedIn = true;
            $this->saveToSession();
            return true;
        }
        $this->isUserLoggedIn = false;
        $this->saveToSession();
        return false;
    }



}
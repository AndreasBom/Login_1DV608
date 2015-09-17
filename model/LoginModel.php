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

    public $userIsLoggedIn = false;


    public function correctLoginCredidentials($userName, $password)
    {
        if(self::$userName == trim($userName) && self::$password == trim($password)){
            return true;
        }

        return false;
    }


}
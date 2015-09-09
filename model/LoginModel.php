<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-08-31
 * Time: 13:17
 */

namespace model;



use view\CookieStorage;

class LoginModel
{
    //dummy data
    private static $dummyUserName = "Admin";
    private static $dummyPassword = "Password";
//////////////////////////////////////////////////////////////////////////

    private static $sessionLocationLoggedIn = 'LoginModel::isUserLoggedIn';



    /**
     * @param $userName: input from user
     * @param $password: input from user
     * @return bool: Is Credidentionals correct
     */
    public function evaluateUserCredidentionals($username, $password)
    {

        if($username == self::$dummyUserName && $password == self::$dummyPassword)
        {
            $_SESSION[self::$sessionLocationLoggedIn] = true;
            return true;

        }
        $_SESSION[self::$sessionLocationLoggedIn] = false;
        return false;
    }

    /**
     * @return bool: is user logged in
     */
    public function isUserLoggedIn()
    {
        if(isset($_SESSION[self::$sessionLocationLoggedIn]))
        {
            return $_SESSION[self::$sessionLocationLoggedIn];
        }

        return false;
    }

    public function logoutUser()
    {
        $_SESSION[self::$sessionLocationLoggedIn] = false;
    }



}
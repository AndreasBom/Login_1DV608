<?php
/**
 * Created by PhpStorm.
 * User: Andreas
<<<<<<< HEAD
 * Date: 2015-09-16
 * Time: 21:26
=======
 * Date: 2015-08-31
 * Time: 13:17
>>>>>>> origin/master
 */

namespace model;

<<<<<<< HEAD
require_once("LoginDAL.php");

class LoginModel
{
    private static $userLoggedInSession = "LoginModel::LoggedIn";
    private static $usernameInSession = "LoginModel::Username";
    private static $users = array();

    public function __construct()
    {
        $dal = new LoginDAL();
        self::$users = $dal->getUsers();
    }

    /**
     * Evaluate if submitted credentional match saved credentional
     *
     * @param string $name
     * @param string $password
     * @return bool
     */
    public function evaluateUserCredentials($name, $password)
    {
        foreach(self::$users as $user)
        {
            if($user->getUsername() === $name && $user->getPassword() === $password)
            {
                $_SESSION[self::$userLoggedInSession] = true;
                return true;
            }
        }

        return false;
    }

    public function setUsernameInSession($name)
    {
        $_SESSION[self::$usernameInSession] = $name;
    }

    public function getUsernameInSession()
    {
        if(isset($_SESSION[self::$usernameInSession]))
        {
            return $_SESSION[self::$usernameInSession];
        }

        return null;

    }

    public function isUserLoggedIn()
    {
        return isset($_SESSION[self::$userLoggedInSession]);
=======


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
>>>>>>> origin/master
    }

    public function logoutUser()
    {
<<<<<<< HEAD
        session_unset();
    }
=======
        $_SESSION[self::$sessionLocationLoggedIn] = false;
    }



>>>>>>> origin/master
}
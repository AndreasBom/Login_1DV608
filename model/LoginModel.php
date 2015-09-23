<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-09-16
 * Time: 21:26
 */

namespace model;

require_once("LoginDAL.php");

class LoginModel
{
    private static $userLoggedInSession = "LoginModel::LoggedIn";
    private static $usernameInSession = "LoginModel::Username";
    private static $users = array();

    /**
     * fake database with user data
     */
    public function __construct()
    {
        $dal = new LoginDAL();
        self::$users = $dal->getUsers();
    }

    /**
     * Evaluate if submitted credentionals match saved credentionals
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


    /**Set username in Session
     * @param $name
     */
    public function setUsernameInSession($name)
    {
        $_SESSION[self::$usernameInSession] = $name;
    }

    /**If session is set, returns bool,
     * if session is not set, returns null
     * @return bool|null
     */
    public function getUsernameInSession()
    {
        if(isset($_SESSION[self::$usernameInSession]))
        {
            return $_SESSION[self::$usernameInSession];
        }

        return null;
    }


    protected function setUserLoggedIn($bool)
    {
        $_SESSION[self::$userLoggedInSession] = $bool;
    }

    /**
     * @return bool
     */
    public function isUserLoggedIn()
    {
        return isset($_SESSION[self::$userLoggedInSession]);
    }

    /**
     * Unset session
     */
    public function logoutUser()
    {
        session_unset();
    }
}
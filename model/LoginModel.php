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
    private static $userName = "Admin";
    private static $password = "Password";

    private $userIsLoggedIn = false;
    private $usernameMissing = true;
    private $passwordMissing = true;



    public function correctLoginCredidentials($userName, $password)
    {
        if(self::$userName == trim($userName) && self::$password == trim($password)){
            $this->userIsLoggedIn = true;
            return true;
        }
        $this->userCredidentialsIsMissing($userName, $password);
        return false;
    }

    private function userCredidentialsIsMissing($username, $password)
    {
        if($username != ""){
            $this->usernameMissing = false;
        }
        if($password != ""){
            $this->passwordMissing = false;
        }
    }

    public function generateResponseMessage(){
        if($this->userIsLoggedIn){
            var_dump("Welcome");
            return "Welcome";
        }
        if($this->usernameMissing){
            var_dump("missing user");
            return "Username is missing";
        }
        if($this->passwordMissing){
            var_dump("missing pass");
            return "Password is missing";
        }

        var_dump("wrong u or p");
        return "Wrong name or password";
    }


}
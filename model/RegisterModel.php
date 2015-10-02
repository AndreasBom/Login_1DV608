<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-01
 * Time: 13:44
 */

namespace model;

use view\LoginView;

class NotValidUserNameException extends \Exception{}
class NotValidPasswordException extends \Exception{}
class PasswordDoNotMatchException extends \Exception{}
class NotUniqueUserNameException extends \Exception{}
class UserNameContainingHTMLTagException extends \Exception{}

class RegisterModel
{
    private $dal;
    private $arrayOfUsers;

    public function __construct()
    {
        $this->dal = new LoginDAL();
        $this->arrayOfUsers = $this->dal->getUsers();
    }

    public function UserNameisUnique($name)
    {
        foreach($this->arrayOfUsers as $user)
        {
            $username = $user->getUsername();
            if(strcmp($username, $name) === 0)
            {
                throw new NotUniqueUserNameException();
            }
        }

        return true;
    }

    public function validateNoHtmlTags($name)
    {
        if(strlen($name) != strlen(strip_tags($name)))
        {
            throw new UserNameContainingHTMLTagException;
        }
    }


    public function validateUsername($username)
    {
        if(strlen($username) < 3)
        {
            throw new NotValidUserNameException("Not valid");
        }

    }

    public function validatePassword($password)
    {
        if(strlen($password) < 6)
        {
            throw new NotValidPasswordException("Not valid");
        }
    }

    public function validateRepetedPassword($password, $repeatedPassword)
    {
        if(strcmp($password, $repeatedPassword) != 0)
        {
            throw new PasswordDoNotMatchException();
        }
    }

    public function saveUser($username, $password)
    {
        $this->dal->saveUser(new User($username, $password));
    }


}
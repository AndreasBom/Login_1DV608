<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-09-09
 * Time: 19:38
 */

namespace model;


class User
{
    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string. Username
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * @return string Password
     */
    public function getPassword()
    {
        return $this->password;
    }
}
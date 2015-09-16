<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-09-09
 * Time: 19:27
 */

namespace model;


class LoginDAL
{
    /**
     * @var array with Userobjects
     */
    private $listOfUsers = array();


    /**
     * Add user to array listOfUsers
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->listOfUsers[] = $user;
    }

    /**
     *
     *
     * @return array|mixed
     */
    public function getUsers()
    {
        if(file_exists("users.txt"))
        {
            $stringData = file_get_contents("users.txt");
            return unserialize($stringData);
        }
        else
        {
            return $this->listOfUsers;
        }


    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-09-17
 * Time: 20:20
 */

namespace model;


class AutoLogin extends LoginModel
{

    /**
     * Generates a unique string, and saves it
     * @param $identifier
     * @return string
     */
    public function generatePasswordString($identifier)
    {
        //Creates a random string and concatenates with hashed username, Delimits with _(underscore)
        $randomString = password_hash($identifier, PASSWORD_DEFAULT) . "_" . sha1(rand());
        //Should be outside 'root', but don't know how to configure my remote host
        file_put_contents("tmp/" . $randomString,'');

        return $randomString;
    }


    /**
     * @param $username
     * @param $passwordString
     * @return bool. Returns true if passwordString in cookie is identical to the one on server
     */
    public function evaluateSavedCredentials($username, $passwordString)
    {
        $extractUsername = explode("_", $passwordString);
        //Verifies that username in cookie is identical to first part of passwordString
        $correctUsername = password_verify($username, $extractUsername[0]); //Bool

        if($correctUsername)
        {
            self::setUserLoggedIn($username);
        }

    }


}
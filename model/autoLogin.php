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
        //$randomString = password_hash($identifier, PASSWORD_DEFAULT) . "_" . sha1(rand());
        //Should be outside 'root', but don't know how to configure my remote host
        //$file = file_put_contents("tmp/" . sha1(rand()),'');
        $username = password_hash($identifier, PASSWORD_DEFAULT);
        $randomString = sha1(rand());
        file_put_contents("tmp/" . $randomString . ".txt", $username );
        return $randomString;
    }


    /**
     * @param $username
     * @param $passwordString
     * @return bool. Returns true if passwordS tring in cookie is identical to the one on server
     */
    public function evaluateSavedCredentials($username, $passwordString)
    {

        if(file_exists("tmp/".$passwordString . ".txt"))
        {
            $usernameInFile = file_get_contents("tmp/".$passwordString . ".txt");
        }
        else
        {
            throw new \Exception("Data handling Error. No user with that name!");
        }



        $correctUsername = password_verify($username, $usernameInFile);

        if($correctUsername)
        {
            self::setUserLoggedIn($username);
        }

    }


}
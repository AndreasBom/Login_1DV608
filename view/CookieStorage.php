<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-09-02
 * Time: 13:37
 */

namespace view;


class CookieStorage
{
    public function save($string){
        setcookie($string, $string, -1);
    }

    public function load($string){
        if(isset($_COOKIE[$string])){
            $ret = $_COOKIE[$string];

        }else{
            $ret = "not set";
        }

        setcookie($string, "", time() - 1);

        return $ret;
    }

}
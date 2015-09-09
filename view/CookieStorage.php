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
    public function save($name, $string)
    {
        setcookie($name, $string, -1);
    }

    public function load($name)
    {
        $ret = '';
        if(isset($_COOKIE[$name]))
        {
            $ret = $_COOKIE[$name];
        }
        else
        {
            return false;
        }

        setcookie($name, "", time() -1);

        return $ret;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-09-16
 * Time: 23:25
 */

namespace view;


class CookieStorage
{
    public function save($name, $value)
    {
        setcookie($name, $value, -1);
    }

    public function loadAndRemove($name)
    {
        $ret = '';
        if(isset($_COOKIE[$name]))
        {
            $ret = $_COOKIE[$name];
        }
        else
        {
            return "";
        }
        setcookie($name, "", time() -1);
        return $ret;
    }

    public function load($name)
    {
        if(isset($_COOKIE[$name]))
        {
            return $_COOKIE[$name];
        }

        return null;
    }
}
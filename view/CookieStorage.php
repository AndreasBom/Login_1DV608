<?php
/**
 * Created by PhpStorm.
 * User: Andreas
<<<<<<< HEAD
 * Date: 2015-09-16
 * Time: 23:25
=======
 * Date: 2015-09-02
 * Time: 13:37
>>>>>>> origin/master
 */

namespace view;


class CookieStorage
{
<<<<<<< HEAD
    public function save($name, $value)
    {
        setcookie($name, $value, -1);
    }

    public function loadAndRemove($name)
=======
    public function save($name, $string)
    {
        setcookie($name, $string, -1);
    }

    public function load($name)
>>>>>>> origin/master
    {
        $ret = '';
        if(isset($_COOKIE[$name]))
        {
            $ret = $_COOKIE[$name];
        }
        else
        {
<<<<<<< HEAD
            return "";
        }
        setcookie($name, "", time() -1);
        return $ret;
    }
<<<<<<< HEAD

    public function load($name)
    {
        if(isset($_COOKIE[$name]))
        {
            return $_COOKIE[$name];
        }

        return null;
    }
=======
=======
            return false;
        }

        setcookie($name, "", time() -1);

        return $ret;
    }

>>>>>>> origin/master
>>>>>>> 06f2d2fa6b9544548e570506b1f9ab8342f191ed
}
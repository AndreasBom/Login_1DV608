<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-10-02
 * Time: 12:00
 */

namespace controller;


class DataController
{
    private $mysqli;

    public function __c()
    {
        $this->mysqli = new \mysqli("localhost", "admin", "1", "loginapp");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
    }
}
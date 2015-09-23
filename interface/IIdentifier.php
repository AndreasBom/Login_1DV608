<?php

/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-09-23
 * Time: 10:44
 */
interface iIdentifier
{
    public function setClientName($name);
    public function setClientId($id);
    public function getClientName();
    public function getClientId();
}
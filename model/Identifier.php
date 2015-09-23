<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-09-23
 * Time: 10:19
 */

namespace model;

require_once('/interface/iIdentifier.php ');

class Identifier implements \iIdentifier
{

    private $name;
    private $id;

    public function __construct($name, $id)
    {
        $this->name = $name;
        $this->id = $id;
    }


    public function setClientName($clientName)
    {
        $this->name = $clientName;
    }

    public function setClientId($id)
    {
        $this->id = $id;
    }

    public function getClientName()
    {
        return $this->name;
    }

    public function getClientId()
    {
        return $this->id;
    }
}
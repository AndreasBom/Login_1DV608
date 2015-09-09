<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-08-31
 * Time: 22:09
 */

namespace model;


class Validation
{
    public function RequiredFieldValidator($fieldToValidate)
    {
        if($fieldToValidate == ""){
            return false;
        }else{
            return true;
        }
    }
}
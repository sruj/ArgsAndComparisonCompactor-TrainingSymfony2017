<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2017-11-20
 * Time: 12:35
 */

namespace AppBundle\Args;

class BoolArgsType implements ArgsTypeInterface
{
    private $parameter;

    public function setParameter($stringParameter)
    {
        if ("true" == trim(strtolower($stringParameter))) {
            $this->parameter = true;
            return;
        }
        $this->parameter = false;
    }

    public function getParameter()
    {
        return $this->parameter;
    }
}
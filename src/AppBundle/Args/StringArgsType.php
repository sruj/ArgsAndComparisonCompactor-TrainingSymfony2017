<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2017-11-20
 * Time: 12:37
 */

namespace AppBundle\Args;


class StringArgsType implements ArgsTypeInterface
{
    private $parameter;

    public function setParameter($stringParameter)
    {
        $this->parameter = $stringParameter;
    }

    public function getParameter()
    {
        return $this->parameter;
    }

}
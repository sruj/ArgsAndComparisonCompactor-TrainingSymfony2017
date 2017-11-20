<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2017-11-20
 * Time: 12:38
 */

namespace AppBundle\Args;


class IntegerArgsType implements ArgsTypeInterface
{
    private $parameter;

    public function setParameter($stringParameter)
    {
        $this->parameter = (int)trim($stringParameter);
    }

    public function getParameter()
    {
        return $this->parameter;
    }

}
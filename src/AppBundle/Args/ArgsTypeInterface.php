<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2017-11-20
 * Time: 12:28
 */

namespace AppBundle\Args;


interface ArgsTypeInterface
{
    public function setParameter($stringParameter);
    public function getParameter();
}
<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2017-11-18
 * Time: 10:35
 */

namespace Tests\AppBundle\Args;

use AppBundle\Args\Args;
use PHPUnit\Framework\TestCase;

class ArgsTest extends TestCase
{
    public function testGetValueByLetter()
    {
        $schema = "l,p#,d*";
        $command = '-l true -p 234 -d Ala';
        $args = new Args($schema, $command);

        $this->assertEquals($args->getValueByLetter('l', 'bool'), true);
        $this->assertEquals($args->getValueByLetter('p', 'intiger'), 234);
        $this->assertEquals($args->getValueByLetter('d', 'string'), 'Ala');
    }
}

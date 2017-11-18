<?php

namespace AppBundle\Args;

class Args
{
    private $schema;
    private $command;

    public function __construct($schema, $command)
    {
        '-l true -p 234 -d Ala';

        $this->command = $command;
        $this->schema = $schema;
    }


/*
CO TO MA ROBIĆ?
CO MA ZWRÓCIĆ?
- WARTOŚCI $inputPattern = '-l true -p 234 -d Ala';

 * */
}
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Command
 *
 * @ORM\Table(name="command")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandRepository")
 */
class Command
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="commandInput", type="string", length=255)
     */
    private $commandInput;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set commandInput
     *
     * @param string $commandInput
     *
     * @return Command
     */
    public function setCommandInput($commandInput)
    {
        $this->commandInput = $commandInput;

        return $this;
    }

    /**
     * Get commandInput
     *
     * @return string
     */
    public function getCommandInput()
    {
        return $this->commandInput;
    }
}


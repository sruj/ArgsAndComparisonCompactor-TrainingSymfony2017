<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compactor
 *
 * @ORM\Table(name="compactor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompactorRepository")
 */
class Compactor
{
    /**
     * @var string
     *
     * @ORM\Column(name="context", type="string", length=255)
     */
    private $context;

    /**
     * @var string
     *
     * @ORM\Column(name="expected", type="string", length=255)
     */
    private $expected;

    /**
     * @var string
     *
     * @ORM\Column(name="actual", type="string", length=255)
     */
    private $actual;

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param string $context
     */
    public function setContext(string $context)
    {
        $this->context = $context;
    }

    /**
     * @return string
     */
    public function getExpected()
    {
        return $this->expected;
    }

    /**
     * @param string $expected
     */
    public function setExpected(string $expected)
    {
        $this->expected = $expected;
    }

    /**
     * @return string
     */
    public function getActual()
    {
        return $this->actual;
    }

    /**
     * @param string $actual
     */
    public function setActual(string $actual)
    {
        $this->actual = $actual;
    }

}


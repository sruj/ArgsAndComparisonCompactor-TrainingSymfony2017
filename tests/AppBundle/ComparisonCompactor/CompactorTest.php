<?php

/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2017-11-21
 * Time: 11:29
 */

namespace Tests\AppBundle\Args;

use AppBundle\ComparisonCompactor\Compactor;
use PHPUnit\Framework\TestCase;

class CompactorTest extends TestCase
{
    /*
     * <... - KROPKI oznaczają że coś tam jeszcze jest ale kontekst ogranicza pokazywanie, np:
     * $contextLength = 1;
     * $expected = "abcef";
     * $actual = "abxef";
     * <...b[c]e...><...b[x]e...>
     *
     * KONTEKST - liczba oznacza kontekst liczbę znaków z każdej strony błędnego znaku [x], np:
     * $contextLength = 2;
     * $expected = "abcef";
     * $actual = "abxef";
     * <ab[c]ef><ab[x]ef>
    */

    public function testCompact1()
    {
        $contextLength = 0;
        $expected = "b";
        $actual = "c";
        $cc = new Compactor($contextLength, $expected, $actual);
        $this->assertEquals("<[b]><[c]>", $cc->compact());
    }

    public function testCompact2()
    {
        $contextLength = 1;
        $expected = "ba";
        $actual = "bc";
        $cc = new Compactor($contextLength, $expected, $actual);
        $this->assertEquals("<b[a]><b[c]>", $cc->compact());
    }

    public function testCompact3()
    {
        $contextLength = 0;
        $expected = "ba";
        $actual = "bc";
        $cc = new Compactor($contextLength, $expected, $actual);
        $this->assertEquals("<...[a]><...[c]>", $cc->compact());
    }

    public function testCompact4()
    {
        $contextLength = 0;
        $expected = "ab";
        $actual = "ab";
        $cc = new Compactor($contextLength, $expected, $actual);
        $this->assertEquals("<ab><ab>", $cc->compact());
    }

    public function testCompact5a()
    {
        $contextLength = 0;
        $expected = "abc";
        $actual = "adc";
        $cc = new Compactor($contextLength, $expected, $actual);
        $this->assertEquals("<...[b]...><...[d]...>", $cc->compact());
    }

    public function testCompact5b()
    {
        $contextLength = 0;
        $expected = "zbc";
        $actual = "abc";
        $cc = new Compactor($contextLength, $expected, $actual);
        $this->assertEquals("<[z]...><[a]...>", $cc->compact());
    }

    public function testCompact5c()
    {
        $contextLength = 1;
        $expected = "abc";
        $actual = "adc";
        $cc = new Compactor($contextLength, $expected, $actual);
        $this->assertEquals("<a[b]c><a[d]c>", $cc->compact());
    }

    public function testCompact6()
    {
        $contextLength = 1;
        $expected = "abc";
        $actual = "adc";
        $cc = new Compactor($contextLength, $expected, $actual);
        $this->assertEquals("<a[b]c><a[d]c>", $cc->compact());
    }

    public function testCompact7()
    {
        $contextLength = 3;
        $expected = "abcxefgh";
        $actual = "abcyefgh";
        $cc = new Compactor($contextLength, $expected, $actual);
        $this->assertEquals("<abc[x]efg...><abc[y]efg...>", $cc->compact());
    }

    public function testCompact8()
    {
        $contextLength = 3;
        $expected = "abcdexgh";
        $actual = "abcdeygh";
        $cc = new Compactor($contextLength, $expected, $actual);
        $this->assertEquals("<...cde[x]gh><...cde[y]gh>", $cc->compact());
    }

    public function testCompact9Exception()
    {
        $this->expectException(\Exception::class);
        $contextLength = 3;
        $expected = "a";
        $actual = "abcdeygh";
        $cc = new Compactor($contextLength, $expected, $actual);
        $cc->compact();
    }
}


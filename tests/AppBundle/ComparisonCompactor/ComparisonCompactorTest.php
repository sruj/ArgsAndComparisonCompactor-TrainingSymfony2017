<?php

/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2017-11-21
 * Time: 11:29
 */
namespace Tests\AppBundle\Args;

use AppBundle\ComparisonCompactor\ComparisonCompactor;
use PHPUnit\Framework\TestCase;

class ComparisonCompactorTest extends TestCase
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
         *
         *
        */

    public function testCompact1()
    {
        $contextLength = 0;
        $expected = "b";
        $actual = "c";
        $cc = new ComparisonCompactor($contextLength,  $expected,  $actual);
        $this->assertEquals($cc->compact(), "<[b]><[c]>" );
    }

    public function testCompact2()
    {
        $contextLength = 1;
        $expected = "ba";
        $actual = "bc";
        $cc = new ComparisonCompactor($contextLength,  $expected,  $actual);
        $this->assertEquals($cc->compact(), "<b[a]><b[c]>" );
    }

    public function testCompact3()
    {
        $contextLength = 0;
        $expected = "ba";
        $actual = "bc";
        $cc = new ComparisonCompactor($contextLength,  $expected,  $actual);
        $this->assertEquals($cc->compact(), "<...[a]><...[c]>" );
    }

    public function testCompact4()
    {
        $contextLength = 0;
        $expected = "ab";
        $actual = "ab";
        $cc = new ComparisonCompactor($contextLength,  $expected,  $actual);
        $this->assertEquals($cc->compact(), "<ab><ab>" );
    }

    public function testCompact5()
    {
        $contextLength = 0;
        $expected = "abc";
        $actual = "adc";
        $cc = new ComparisonCompactor($contextLength,  $expected,  $actual);
        $this->assertEquals($cc->compact(), "<...[b]...><...[d]...>" );
    }

    public function testCompact6()
    {
        $contextLength = 1;
        $expected = "abc";
        $actual = "adc";
        $cc = new ComparisonCompactor($contextLength,  $expected,  $actual);
        $this->assertEquals($cc->compact(), "<a[b]c><a[d]c>" );
    }

    public function testCompact7()
    {
        $contextLength = 3;
        $expected = "abcxefgh";
        $actual = "abcyefgh";
        $cc = new ComparisonCompactor($contextLength,  $expected,  $actual);
        $this->assertEquals($cc->compact(), "<abc[x]efg...><abc[y]efg...>" );
    }
}


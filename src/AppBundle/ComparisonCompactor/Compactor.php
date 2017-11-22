<?php

namespace AppBundle\ComparisonCompactor;

class Compactor
{
    private $context;
    private $expStr;
    private $actStr;
    private static $openBracket = "<";
    private static $closedBracket = ">";
    private static $ellipsis = "...";
    private static $leftBractet = "[";
    private static $rightBractet = "]";


    public function __construct(int $contextLength, string $expected, string $actual)
    {
        $this->context = $contextLength;
        $this->expStr = $expected;
        $this->actStr = $actual;
    }

    public function compact()
    {
        $result = null;
        $this->checkStringsValidity();

        if ($this->areStringsSame()) {
            return $this->prepareResultForLackOfErrorLetter();
        }

        $strings = $this->compareStrings();
        $errLetterExp = $this->surroundErrorLetter($strings['err_exp']);
        $errLetterAct = $this->surroundErrorLetter($strings['err_act']);
        $expStr = $this->splitStrToArray($this->expStr);
        $result = $this->createResult($expStr, $strings['err_pos'], $result, $errLetterExp);
        $result = $this->createResult($expStr, $strings['err_pos'], $result, $errLetterAct);

        return $result;
    }

    private function checkStringsValidity()
    {
        $sum = strlen($this->actStr) - strlen($this->expStr);
        if ($sum > 1 || $sum < -1) {
            throw new \Exception("Strings lenght error. Number of letters in compared string must be equal or not bigger than 1 letter.");
        }
        if ($this->actStr == null || $this->expStr == null) {
            throw new \Exception("One of strings are empty");
        }
        if (!$this->doesStringsHaveEqualLength()) {
            throw new \Exception("I can only compare srings with same length.");
        }
    }

    private function areStringsSame()
    {
        if ($this->expStr === $this->actStr) {
            return true;
        }
        return false;
    }

    private function prepareResultForLackOfErrorLetter(): string
    {
        return Compactor::$openBracket . $this->expStr . Compactor::$closedBracket .
            Compactor::$openBracket . $this->actStr . Compactor::$closedBracket;
    }

    private function compareStrings()
    {
        $exAr = $this->splitStrToArray($this->expStr);
        $acAr = $this->splitStrToArray($this->actStr);
        $errorFound = false;
        $strErr = [];
        $i = 0;
        foreach ($exAr as $currExpLett) {
            $currArcLett = $acAr[$i];
            if ($currExpLett != $currArcLett) {
                if ($errorFound) {
                    throw new \Exception("To many diffrent letters. I can count to ONE.");
                }
                $errorFound = true;
                $strErr['err_pos'] = $i;
                $strErr['err_exp'] = $currExpLett;
                $strErr['err_act'] = $currArcLett;
            }
            $i++;
        }

        return $strErr;
    }

    private function splitStrToArray($str): array
    {
        return str_split($str);
    }

    private function surroundErrorLetter($letter): string
    {
        return Compactor::$leftBractet . $letter . Compactor::$rightBractet;
    }

    private function createResult($expStr, $errPos, $result, $errLetter): string
    {
        $currPos = 1;
        $preErrExpStr = array_slice($expStr, 0, $errPos);
        $postErrExpStr = array_slice($expStr, $errPos + 1);
        $strLnght = count($postErrExpStr);
        $result .= Compactor::$openBracket;

        foreach ($preErrExpStr as $currChar) {
            $result = $this->findCommonPrefixLetters($errPos + 1, $result, $currPos, $currChar);
            $currPos++;
        }

        $result = $this->insertErrorLetter($result, $errLetter);
        $currPos = 1;

        foreach ($postErrExpStr as $currChar) {
            $result = $this->findCommonSufixLetters($result, $currPos, $strLnght, $currChar);
            $currPos++;
        }
        $result .= Compactor::$closedBracket;

        return $result;
    }

    private function findCommonPrefixLetters($errPos, $result, $currPos, $currChar): string
    {
        if ($this->isFirstLetterInString($currPos)) {
            if ($this->isLetterOutOfContext($errPos, $currPos)) {
                $result .= Compactor::$ellipsis;
            } else {
                $result .= $currChar;
            }
        } else {
            if (!$this->isLetterOutOfContext($errPos, $currPos)) {
                $result .= $currChar;
            }
        }
        return $result;
    }

    private function isFirstLetterInString($i): bool
    {
        return $i == 1;
    }

    private function isLetterOutOfContext($errPos, $currPos): bool
    {
        return $errPos - $currPos > $this->context;
    }

    private function insertErrorLetter($result, $errLetter): string
    {
        $result .= $errLetter;
        return $result;
    }

    private function doesStringsHaveEqualLength(): bool
    {
        return strlen($this->expStr) == strlen($this->actStr);
    }

    private function findCommonSufixLetters($result, $currPos, $strLnght, $currChar): string
    {
        if ($this->isLastLetter($currPos, $strLnght)) {
            if ($this->isOutOfContext($currPos)) {
                $result .= Compactor::$ellipsis;
            } else {
                $result .= $currChar;
            }
        } else {
            if (!$this->isOutOfContext($currPos)) {
                $result .= $currChar;
            }
        }
        return $result;
    }

    private function isLastLetter($currPos, $strLnght): bool
    {
        return $currPos == $strLnght;
    }

    private function isOutOfContext($currPos): bool
    {
        return $currPos > $this->context;
    }
}
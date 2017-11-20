<?php

namespace AppBundle\Args;

use AppBundle\Args\BoolArgsType;
use AppBundle\Args\IntegerArgsType;
use AppBundle\Args\StringArgsType;

class Args
{
    private $arguments;

    /**
     * Zadania tej klasy:
     * - rozpoznać schemat formatki (np "l,p#,d*" oznacza: " " bool, "#" int, "*" string)
     * - rozdzielić komendę na części (tablica argumentów i ich wartości)
     * - sprawdzić poprawność typów wprowadzonych wartości argumentów komendy na podstawie formatki
     * - zwrócić wartości argumentów komendy we właściwym typie danych
     * - zwracać błędy
     *
     * Typy Danych:
     * - " " bool,
     * - "#" int,
     * - "*" string
     *
     * Kontrola Błędów:
     * - gdy wartość argumentu komendy pusta
     * - gdy ma niewłaściwy typ danych
     **/
    public function __construct($schema, $command)
    {
        $this->prepareCommandValues($schema, $command);
    }

    private function prepareCommandValues($schema, $command)
    {
        $this->prepareArgumentsWithTheirTypesArray($schema);
        $this->prepareCommandPiecesArray($command);
    }

    private function prepareArgumentsWithTheirTypesArray($schema)
    {
        $splittedSchemaArray = $this->splitSchema($schema);
        $this->convertToTypes($splittedSchemaArray);
    }

    private function splitSchema($schema): array
    {
        $splittedArray = explode(',', $schema);
        $arr = [];
        foreach ($splittedArray as $item) {
            $arr[substr($item, 0, 1)] = substr($item, 1, 1);
        }

        return $arr;
    }

    private function convertToTypes($arr)
    {
        foreach ($arr as $argument => $typeChar) {
            switch ($typeChar) {
                case "":
                    $this->arguments[$argument] = new BoolArgsType();
                    break;
                case "#":
                    $this->arguments[$argument] = new IntegerArgsType();
                    break;
                case "*":
                    $this->arguments[$argument] = new StringArgsType();
                    break;
            }
        }
    }

    private function prepareCommandPiecesArray($command)
    {
        $pieces = $this->splitCommand($command);

        $actualParameter = null;

        foreach ($pieces as $item) {
            $firstLetter = substr($item, 0, 1);
            $secondLetter = substr($item, 1);
            if ($this->isCommandArgument($firstLetter, $secondLetter)) {
                $actualParameter = $secondLetter;
            } else { //command parameter value
                $this->convertStringIntoType($item, $this->arguments[$actualParameter]);
                $actualParameter = null;
            }
        }
    }

    private function splitCommand($command)
    {
        $pieces = explode(" ", $command);

        return $pieces;
    }

    private function isCommandArgument($firstLetter, $secondLetter): bool
    {
        return $this->isDash($firstLetter) and $this->isLetter($secondLetter);
    }

    private function isDash($firstLetter): bool
    {
        return $firstLetter == "-";
    }

    private function isLetter($letter): int
    {
        return preg_match('/[a-zA-Z]/', $letter);
    }

    private function convertStringIntoType($stringParameter, ArgsTypeInterface $argsType)
    {
        $argsType->setParameter($stringParameter);
    }

    private function isLetterExists($letter): bool
    {
        return (array_key_exists($letter, $this->arguments));
    }

    public function getValueByLetter($letter, string $type)
    {
        $argsType = $this->arguments[$letter];

        if ($this->isLetterExists($letter)) {
            return $this->getParameter($argsType);
        }

        return false;
    }

    private function getParameter(ArgsTypeInterface $argsType)
    {
        return $argsType->getParameter();
    }

}
<?php

namespace AppBundle\Args;

class Args
{
    private $commandPieces;
    private $argumentsTypes;

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
        $argumentsTypes = $this->prepareArgumentsWithTheirTypesArray($schema);
        $this->prepareCommandPiecesArray($command, $argumentsTypes);
    }

    private function prepareArgumentsWithTheirTypesArray($schema)
    {
        $splittedSchemaArray = $this->splitSchema($schema);
        $argumentsWithTypes = $this->convertToTypes($splittedSchemaArray);
        $this->argumentsTypes = $argumentsWithTypes;

        return $argumentsWithTypes;
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
                    $arr[$argument] = "bool";
                    break;
                case "#":
                    $arr[$argument] = "intiger";
                    break;
                case "*":
                    $arr[$argument] = "string";
                    break;
            }
        }
        return $arr;
    }

    private function prepareCommandPiecesArray($command, $argumentsTypes)
    {
        $pieces = $this->splitCommand($command);

        $commandPieces = [];
        $actualParameter = null;

        foreach ($pieces as $item) {
            $firstLetter = substr($item, 0, 1);
            $secondLetter = substr($item, 1);
            if ($this->isCommandArgument($firstLetter, $secondLetter)) {
                $commandPieces[$secondLetter] = null;
                $actualParameter = $secondLetter;
            } else {
                $commandPieces[$actualParameter] = $this->convertStringIntoType($item, $argumentsTypes[$actualParameter]);
                $actualParameter = null;
            }
        }
        $this->commandPieces = $commandPieces;

        return $commandPieces;
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

    private function convertStringIntoType($stringParameter, $type)
    {
        $convertedValue = null;

        switch ($type) {
            case "bool":
                $convertedValue = $this->convertBool($stringParameter);
                break;
            case "string":
                $convertedValue = $this->convertString($stringParameter);
                break;
            case "intiger":
                $convertedValue = $this->convertIntiger($stringParameter);
                break;
        }
        return $convertedValue;
    }

    private function convertBool($stringParameter)
    {
        if ("true" == trim(strtolower($stringParameter))) {
            return true;
        }
        return false;
    }

    private function convertString($stringParameter)
    {
        return $stringParameter;
    }

    private function convertIntiger($stringParameter)
    {
        return (int)trim($stringParameter);
    }

    private function isTypeCompatibile($letter, string $type): bool
    {
        return ($this->argumentsTypes[$letter] == $type);
    }

    private function isLetterExists($letter): bool
    {
        return (array_key_exists($letter, $this->commandPieces));
    }

    public function getValueByLetter($letter, string $type)
    {
        if ($this->isLetterExists($letter) and $this->isTypeCompatibile($letter, $type)) {
            return $this->commandPieces[$letter];
        }

        return false;
    }

}
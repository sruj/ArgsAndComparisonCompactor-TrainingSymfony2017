<?php

namespace AppBundle\Args;

class Args
{
    private $schema;
    private $command;
    private $pieces;
    private $commandPieces;

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
        $schema = "l,p#,d*";
        $command = '-l true -p 234 -d Ala';

        $this->command = $command;
        $this->schema = $schema;

        $pieces = $this->splitCommand($command);
        $commandPieces = $this->prepareCommandPieces($pieces);
        $this->commandPieces = $commandPieces;
    }

    private function splitCommand($command)
    {
        $pieces = explode(" ", $command);

        return $pieces;
    }

    private function prepareCommandPieces($pieces)
    {
        $commandPieces = [];
        $actualParameter = null;

        foreach ($pieces as $item) {
            $firstLetter = substr($item, 0, 1);
            $secondLetter = substr($item, 1);
            if ($this->isParameter($firstLetter, $secondLetter)) {
                $commandPieces[$secondLetter] = null;
                $actualParameter = $secondLetter;
            } else {
                $commandPieces[$actualParameter] = $item;
                $actualParameter = null;
            }
        }

        return $commandPieces;
    }

    private function isLetter($letter): int
    {
        return preg_match('/[a-zA-Z]/', $letter);
    }

    private function isDash($firstLetter): bool
    {
        return $firstLetter == "-";
    }

    private function isParameter($firstLetter, $secondLetter): bool
    {
        return $this->isDash($firstLetter) and $this->isLetter($secondLetter);
    }

    public function getValueByLetter($letter)
    {
        if (array_key_exists($letter, $this->commandPieces)) {
            return $this->commandPieces[$letter];
        }

        return false;
    }
}
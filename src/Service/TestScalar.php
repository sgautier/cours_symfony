<?php

declare(strict_types=1);

namespace App\Service;

class TestScalar
{
    private string $myString;
    private int $myInt;

    public function __construct(string $myString, int $myInt)
    {
        $this->myString = $myString;
        $this->myInt = $myInt;
    }

    public function __toString()
    {
        return "Values : {$this->myString} - {$this->myInt}";
    }
}

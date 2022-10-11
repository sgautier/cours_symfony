<?php

declare(strict_types=1);

namespace App\Service;

class TestScalar
{
    private string $myString;
    private int $myInt;
    private string $myConstant;
    private array $array;

    public function __construct(string $myString, int $myInt, string $myConstant, array $array)
    {
        $this->myString = $myString;
        $this->myInt = $myInt;
        $this->myConstant = $myConstant;
        $this->array = $array;
    }

    public function __toString()
    {
        return "Values : {$this->myString} - {$this->myInt} - {$this->myConstant} - "
            . implode(', ', $this->array)
            ;
    }
}

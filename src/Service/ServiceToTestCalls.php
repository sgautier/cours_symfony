<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Log\LoggerInterface;

class ServiceToTestCalls
{
    public function myMethod(): void
    {
        dump('Appelle myMethod');
    }

    public function mySecondMethod(int $a, string $b): void
    {
        dump("$a $b");
    }

    public function myOtherMethod(LoggerInterface $logger): void
    {
        dump(get_class($logger));
    }
}

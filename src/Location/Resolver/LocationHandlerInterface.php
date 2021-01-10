<?php

declare(strict_types=1);

namespace App\Location\Resolver;

use App\Model\Location;

interface LocationHandlerInterface
{
    public function process(Location $location): void;

    public function setSuccessor(?LocationHandlerInterface $successor): void;
}

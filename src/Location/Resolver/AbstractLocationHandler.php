<?php

declare(strict_types=1);

namespace App\Location\Resolver;

use App\Model\Location;

abstract class AbstractLocationHandler implements LocationHandlerInterface
{
    protected ?LocationHandlerInterface $successor = null;

    final public function setSuccessor(?LocationHandlerInterface $successor): void
    {
        $this->successor = $successor;
    }

    final public function processNext(Location $location): void
    {
        if (!$this->successor) {
            return;
        }

        $this->successor->process($location);
    }
}

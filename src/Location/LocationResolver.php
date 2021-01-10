<?php

declare(strict_types=1);

namespace App\Location;

use App\Exception\LocationIsNotResolvedException;
use App\Location\Resolver\LocationHandlerInterface;
use App\Model\Location;

class LocationResolver
{
    private LocationHandlerInterface $locationHandler;

    /**
     * @param LocationHandlerInterface $locationHandler
     */
    public function __construct(LocationHandlerInterface $locationHandler)
    {
        $this->locationHandler = $locationHandler;
    }

    /**
     * @param Location $location
     *
     * @throws LocationIsNotResolvedException
     */
    public function resolveLocation(Location $location): void
    {
        $this->locationHandler->process($location);

        if (!$location->isResolved()) {
            throw new LocationIsNotResolvedException('Location is not resolved');
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Location\Resolver;

use App\Model\Location;
use App\LocationProvider\OpenStreetMapsLocationProvider;

class NameLocationHandler extends AbstractLocationHandler
{
    private OpenStreetMapsLocationProvider $openStreetMapsLocationProvider;

    public function __construct(OpenStreetMapsLocationProvider $openStreetMapsLocationProvider)
    {
        $this->openStreetMapsLocationProvider = $openStreetMapsLocationProvider;
    }

    public function process(Location $location): void
    {
        if ($location->isResolved() || null === $location->getName()) {
            $this->processNext($location);

            return;
        }

        $locationData = $this->openStreetMapsLocationProvider->getByName($location->getName());

        $location->setPoint($locationData['point']);
        $location->setStreet($locationData['street']);
        $location->setCity($locationData['city']);
        $location->setCountry($locationData['country']);
        $location->setResolved(true);

        $this->processNext($location);
    }
}

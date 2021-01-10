<?php

declare(strict_types=1);

namespace App\Location\Resolver;

use App\LocationProvider\GoogleMapsLocationProvider;
use App\Model\Location;

class CoordinatesLocationHandler extends AbstractLocationHandler
{
    private GoogleMapsLocationProvider $googleMapsLocationProvider;

    public function __construct(GoogleMapsLocationProvider $googleMapsLocationProvider)
    {
        $this->googleMapsLocationProvider = $googleMapsLocationProvider;
    }

    public function process(Location $location): void
    {
        if ($location->isResolved() || !$location->getPoint()) {
            $this->processNext($location);

            return;
        }

        $locationData = $this->googleMapsLocationProvider->getByPoint($location->getPoint());

        $location->setName($locationData['name']);
        $location->setStreet($locationData['street']);
        $location->setCity($locationData['city']);
        $location->setCountry($locationData['country']);
        $location->setResolved(true);

        $this->processNext($location);
    }
}

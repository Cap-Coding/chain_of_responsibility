<?php

declare(strict_types=1);

namespace App\Location\Resolver;

use App\Model\Location;
use App\LocationProvider\FavouriteLocationRepository;

class FavouritesLocationHandler extends AbstractLocationHandler
{
    private FavouriteLocationRepository $favouriteLocationRepository;

    public function __construct(FavouriteLocationRepository $locationDataRepository)
    {
        $this->favouriteLocationRepository = $locationDataRepository;
    }

    public function process(Location $location): void
    {
        if ($location->isResolved() || null === $location->getName()) {
            $this->processNext($location);

            return;
        }

        $locationData = $this->favouriteLocationRepository->getOneByName($location->getName());

        if (empty($locationData)) {
            $this->processNext($location);

            return;
        }

        $location->setPoint($locationData['point']);

        $this->processNext($location);
    }
}

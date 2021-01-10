<?php

declare(strict_types=1);

namespace App\LocationProvider;

use App\Model\Point;

class FavouriteLocationRepository
{
    public function getOneByName(string $name): array
    {
        return [
            'name' => $name,
            'point' => new Point(1, 1),
        ];
    }
}

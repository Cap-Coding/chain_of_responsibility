<?php

declare(strict_types=1);

namespace App\LocationProvider;

use App\Model\Point;

class OpenStreetMapsLocationProvider
{
    public function getByName(string $name): array
    {
        return [
            'iata' => 'MUC',
            'name' => $name,
            'point' => new Point(1, 1),
            'city' => 'Munich',
            'country' => 'Germany',
            'street' => 'Nordallee 25',
        ];
    }
}

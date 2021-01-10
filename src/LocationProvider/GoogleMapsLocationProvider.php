<?php

declare(strict_types=1);

namespace App\LocationProvider;

use App\Model\Point;

class GoogleMapsLocationProvider
{
    public function getByPoint(Point $point): array
    {
        return [
            'iata' => 'MUC',
            'name' => 'Munich International Airport',
            'point' => $point,
            'city' => 'Munich',
            'country' => 'Germany',
            'street' => 'Nordallee 25',
        ];
    }
}

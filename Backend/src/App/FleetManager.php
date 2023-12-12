<?php

declare(strict_types=1);

namespace Fulll\App;

use Fulll\Domain\Fleet;
use Fulll\Domain\Location;
use Fulll\Domain\Vehicle;

class FleetManager
{

    public function registerVehicleToFleet(Fleet $fleet, Vehicle $vehicle)
    {
        if ($vehicle->getFleet() === $fleet) {
            throw new \Exception('Vehicle already in this fleet !');
        }
        $fleet->addVehicle($vehicle);
        $vehicle->setFleet($fleet);
    }

    public function parkVehicleToLocation(Vehicle $vehicle, Location $location)
    {
        if ($vehicle->getLocation() === $location) {
            throw new \Exception('Vehicle already in this location !');
        }
        $vehicle->setLocation($location);
    }

}

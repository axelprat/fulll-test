<?php

declare(strict_types=1);

namespace Fulll\App;

use Fulll\Domain\Fleet;
use Fulll\Domain\Location;
use Fulll\Domain\Vehicle;
use Fulll\Infra\FleetRepository;
use Fulll\Infra\VehicleRepository;

class FleetManager
{

    /** @var FleetRepository $fleetRepository */
    protected FleetRepository $fleetRepository;

    /** @var VehicleRepository $vehicleRepository */
    protected VehicleRepository $vehicleRepository;

    public function __construct()
    {
        $this->fleetRepository = new FleetRepository();
        $this->vehicleRepository = new VehicleRepository();
    }

    public function registerVehicleToFleet(Fleet $fleet, Vehicle $vehicle)
    {
        if (!empty($vehicle->getFleet()) && $vehicle->getFleet()->getUser() === $fleet->getUser()) {
            throw new \Exception('Vehicle already in this fleet !');
        }
        $fleet->addVehicle($vehicle);
        $vehicle->setFleet($fleet);
        $this->vehicleRepository->saveFleet($vehicle);
    }

    public function parkVehicleToLocation(Vehicle $vehicle, Location $location)
    {
        if (
            $vehicle->getLocation()
            && $vehicle->getLocation()->getLat() === $location->getLat()
            && $vehicle->getLocation()->getLong() === $location->getLong()
            && $vehicle->getLocation()->getAlt() === $location->getAlt()
        ) {
            throw new \Exception('Vehicle already in this location !');
        }
        $vehicle->setLocation($location);
        $this->vehicleRepository->saveLocation($vehicle);
    }

}

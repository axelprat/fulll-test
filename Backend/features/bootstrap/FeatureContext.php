<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use RuntimeException;
use Fulll\App\Calculator;
use Fulll\App\FleetManager;
use Fulll\Domain\Fleet;
use Fulll\Domain\Location;
use Fulll\Domain\Vehicle;

class FeatureContext implements Context
{
    /**
     * @When I multiply :a by :b into :var
     */
    public function iMultiply(int $a, int $b, string $var): void
    {
        $calculator = new Calculator();
        $this->$var = $calculator->multiply($a, $b);
    }

    /**
     * @Then :var should be equal to :value
     */
    public function aShouldBeEqualTo(string $var, int $value): void
    {
        if ($value !== $this->$var) {
            throw new RuntimeException(sprintf('%s is expected to be equal to %s, got %s', $var, $value, $this->$var));
        }
    }

    /*           Axel              */

    /**
     * @Given my fleet
     */
    public function givenMyFleet(): void
    {
        $this->myFleet = new Fleet('Axel');
    }

    /**
     * @Given the fleet of another user
     */
    public function otherUserFleet(): void
    {
        $this->otherFleet = new Fleet('Toto');
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle(): void
    {
        $this->vehicle = new Vehicle('a');
    }

    /**
     * @Given I have registered this vehicle into my fleet
     * @When I register this vehicle into my fleet
     */
    public function registerVehicleToMyFleet(): void
    {
        $fleetManager = new FleetManager();
        $fleetManager->registerVehicleToFleet($this->myFleet, $this->vehicle);
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function registerVehicleToOtherFleet(): void
    {
        $fleetManager = new FleetManager();
        $fleetManager->registerVehicleToFleet($this->otherFleet, $this->vehicle);
    }

    /**
     * @Given a location
     */
    public function aLocation()
    {
        $this->location = new Location(43.4256532,5.2871208);
    }

    /**
     * @Given my vehicle has been parked into this location
     * @When I park my vehicle at this location
     */
    public function myVehicleParkedInLocation()
    {
        $fleetManager = new FleetManager();
        $fleetManager->parkVehicleToLocation($this->vehicle, $this->location);
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function tryToRegisterVehicleIntoMyFleet()
    {
        $fleetManager = new FleetManager();
        try {
            $fleetManager->registerVehicleToFleet($this->myFleet, $this->vehicle);
        } catch (\Exception $ex) {
            $this->catchedException = $ex;
        }
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function tryToParkVehicleAtLocation()
    {
        $fleetManager = new FleetManager();
        try {
            $fleetManager->parkVehicleToLocation($this->vehicle, $this->location);
        } catch (\Exception $ex) {
            $this->catchedException = $ex;
        }
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function vehicleIsInMyFleet(): void
    {
        if ($this->vehicle->getFleet()->getUser() !== $this->myFleet->getUser()) {
            throw new RuntimeException(sprintf(
                'Vehicle %s should be in fleet %s, got %s',
                $this->vehicle->getLicencePlate(),
                $this->myFleet->getUser(),
                $this->vehicle->getFleet()->getUser()
            ));
        }
    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     */
    public function vehicleAlreadyInMyFleet(): void
    {
        if (
            !isset($this->catchedException)
            || !($this->catchedException instanceof Exception)
            || $this->catchedException->getMessage() !== 'Vehicle already in this fleet !'
        ) {
            throw new RuntimeException('Vehicle did not express its membership in my fleet');
        }
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function vehicleIsInLocation(): void
    {
        if (
            !$this->vehicle->getLocation()
            || $this->vehicle->getLocation()->getLat() !== $this->location->getLat()
            || $this->vehicle->getLocation()->getLong() !== $this->location->getLong()
            || $this->vehicle->getLocation()->getAlt() !== $this->location->getAlt()
        ) {
            throw new RuntimeException(sprintf(
                'Vehicle %s should be in location %s, got %s',
                $this->vehicle->getLicencePlate(),
                $this->location->getPlace(),
                $this->vehicle->getLocation()->getPlace()
            ));
        }
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function vehicleAlreadyInLocation(): void
    {
        if (
            !isset($this->catchedException)
            || !($this->catchedException instanceof Exception)
            || $this->catchedException->getMessage() !== 'Vehicle already in this location !'
        ) {
            throw new RuntimeException('Vehicle did not express its presence at this location');
        }
    }

}

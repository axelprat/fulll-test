<?php

namespace Fulll\Infra;

use Fulll\Domain\Vehicle;
use Fulll\Domain\Location;
use PDO;
use PDOException;

class VehicleRepository extends AbstractPdo
{

    /**
     * @param $vehicleId
     * @return Vehicle
     */
    public function getById($vehicleId): Vehicle
    {
        $stmt = $this->pdo->prepare('SELECT * FROM vehicle WHERE id = :id');
        $stmt->bindParam(':id', $vehicleId, PDO::PARAM_INT);
        $stmt->execute();

        $vehicleData = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($vehicleData)) {
            throw new PDOException("Vehicle #$vehicleId not found");
        }

        return $this->loadVehicle($vehicleData);
    }

    /**
     * @param $vehicleLicence
     * @return Vehicle|null
     */
    public function getByLicence($vehicleLicence): ?Vehicle
    {
        $stmt = $this->pdo->prepare('SELECT * FROM vehicle WHERE licence_plate = :licence');
        $stmt->bindParam(':licence', $vehicleLicence, PDO::PARAM_STR);
        $stmt->execute();

        $vehicleData = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($vehicleData)) {
            return null;
        }

        return $this->loadVehicle($vehicleData);
    }

    protected function loadVehicle(array $vehicleData): Vehicle
    {
        $vehicle = new Vehicle($vehicleData['licence_plate'], $vehicleData['id']);

        // Je ne sais pas si tout cela a bien sa place ici mais je ne suis pas encore à l'aise avec le DDD et le CQRS
        if (!empty($vehicleData['fleet_id'])) {
            $fleetRepository = new FleetRepository();
            $fleet = $fleetRepository->getById($vehicleData['fleet_id']);
            $vehicle->setFleet($fleet);
        }
        if (!empty($vehicleData['lat']) && !empty($vehicleData['lng'])) {
            $location = new Location($vehicleData['lat'], $vehicleData['lng'], $vehicleData['alt']);
            $vehicle->setLocation($location);
        }
        // Vivement des explications plus détaillées pour mieux comprendre

        return $vehicle;
    }

    public function save(Vehicle $vehicle)
    {
        $licence = $vehicle->getLicencePlate();
        if ($vehicle->getId() === null) {
            $stmt = $this->pdo->prepare('INSERT INTO vehicle (licence_plate) VALUES (:licence)');
            $stmt->bindParam(':licence', $licence);
            $stmt->execute();
            $vehicle->setId($this->pdo->lastInsertId());
        } else {
            $id = $vehicle->getId();
            $stmt = $this->pdo->prepare('UPDATE vehicle SET licence_plate = :licence WHERE id = :id');
            $stmt->bindParam(':licence', $licence);
            $stmt->bindParam(':id', $id );
            $stmt->execute();
        }
    }

    public function saveFleet(Vehicle $vehicle) {
        $id = $vehicle->getId();
        $fleetId = $vehicle->getFleet()->getId();
        $stmt = $this->pdo->prepare('UPDATE vehicle SET fleet_id = :fleet_id WHERE id = :id');
        $stmt->bindParam(':fleet_id', $fleetId);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function saveLocation(Vehicle $vehicle) {
        $id = $vehicle->getId();
        $lat = $vehicle->getLocation()->getLat();
        $long = $vehicle->getLocation()->getLong();
        $alt = $vehicle->getLocation()->getAlt();
        $stmt = $this->pdo->prepare('UPDATE vehicle SET lat = :lat, lng = :lng, alt = :alt WHERE id = :id');
        $stmt->bindParam(':lat', $lat);
        $stmt->bindParam(':lng', $long);
        $stmt->bindParam(':alt', $alt);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

}

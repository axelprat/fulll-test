<?php

namespace Fulll\Infra;

use Fulll\Domain\Fleet;
use PDO;

class FleetRepository extends AbstractPdo
{

    /**
     * @param $fleetId
     * @return Fleet
     */
    public function getById($fleetId): Fleet
    {
        $stmt = $this->pdo->prepare('SELECT * FROM fleet WHERE id = :id');
        $stmt->bindParam(':id', $fleetId, PDO::PARAM_INT);
        $stmt->execute();

        $fleetData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($fleetData)) {
            throw new PDOException("Fleet #$fleetId not found");
        }

        return new Fleet($fleetData['user_id'], $fleetData['id']);
    }

    public function save(Fleet $fleet)
    {
        $user = $fleet->getUser();
        if ($fleet->getId() === null) {
            $stmt = $this->pdo->prepare('INSERT INTO fleet (user_id) VALUES (:user_id)');
            $stmt->bindParam(':user_id', $user);
            $stmt->execute();
            $fleet->setId($this->pdo->lastInsertId());
        } else {
            $stmt = $this->pdo->prepare('UPDATE fleet SET user_id = :user_id WHERE id = :id');
            $id = $fleet->getId();
            $stmt->bindParam(':user_id', $user);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
    }

}

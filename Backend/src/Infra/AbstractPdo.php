<?php

namespace Fulll\Infra;

use PDO;

abstract class AbstractPdo
{

    protected PDO $pdo;

    public function __construct() {
        $dbName = 'fleet_db';
        $userName = 'user';
        $password = 'password';
        $dsn = "mysql:host=localhost;dbname=$dbName";

        $this->pdo = new PDO($dsn, $userName, $password);
    }
}

<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Fleet
{

    /** @var string $user */
    protected string $user;

    /** @var array $vehicles */
    protected array $vehicles = [];

    public function __construct(string $userName)
    {
        $this->user = $userName;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    public function addVehicle(Vehicle $vehicle)
    {
        $this->vehicles[] = $vehicle;
    }

}

<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Fleet
{

    /** @var ?int $id */
    protected ?int $id;

    /** @var string $user */
    protected string $user;

    /** @var array $vehicles */
    protected array $vehicles = [];

    public function __construct(string $userName, ?int $id = null)
    {
        $this->id = $id;
        $this->user = $userName;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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

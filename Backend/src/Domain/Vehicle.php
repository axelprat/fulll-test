<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Vehicle
{

    /** @var ?int $id */
    protected ?int $id;

    /** @var string $licencePlate */
    protected string $licencePlate;

    /** @var ?Fleet $fleet */
    protected ?Fleet $fleet = null;

    /** @var ?Location $location */
    protected ?Location $location = null;

    public function __construct(string $licencePlate, ?int $id = null)
    {
        $this->id = $id;
        $this->licencePlate = $licencePlate;
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
     * @param string $licencePlate
     */
    public function setLicencePlate(string $licencePlate)
    {
        $this->licencePlate = $licencePlate;
    }

    /**
     * @return string
     */
    public function getLicencePlate(): string
    {
        return $this->licencePlate;
    }

    /**
     * @param Fleet $fleet
     */
    public function setFleet(Fleet $fleet)
    {
        $this->fleet = $fleet;
    }

    /**
     * @return Fleet|null
     */
    public function getFleet(): ?Fleet
    {
        return $this->fleet;
    }

    /**
     * @param Location $location
     */
    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

    /**
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

}

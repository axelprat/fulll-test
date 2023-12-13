<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Location
{

    /** @var float $lat */
    protected float $lat;

    /** @var float $long */
    protected float $long;

    /** @var ?float $alt */
    protected ?float $alt;

    public function __construct(float $lat, float $long, ?float $alt = null)
    {
        $this->lat = $lat;
        $this->long = $long;
        $this->alt = $alt;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function setLat(float $lat)
    {
        $this->lat = $lat;
    }

    public function getLong(): float
    {
        return $this->long;
    }

    public function setLong(float $long)
    {
        $this->long = $long;
    }

    public function getAlt(): ?float
    {
        return $this->alt;
    }

    public function setAlt(?float $alt)
    {
        $this->alt = $alt;
    }

    public function getPlace(): string
    {
        return $this->lat . ',' . $this->long . (!is_null($this->alt) ? ':' . $this->alt : '');
    }

}

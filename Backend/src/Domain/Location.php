<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Location
{

    /** @var string $place */
    protected string $place;

    public function __construct($place)
    {
        $this->place = $place;
    }

    /**
     * @return string
     */
    public function getPlace(): string
    {
        return $this->place;
    }

}

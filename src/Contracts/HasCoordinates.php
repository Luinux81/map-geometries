<?php

namespace LBCDev\MapGeometries\Contracts;

interface HasCoordinates
{
    /**
     * Get the latitude
     */
    public function getLatitude(): float;

    /**
     * Get the longitude
     */
    public function getLongitude(): float;

    /**
     * Get coordinates as array [lat, lng]
     */
    public function getCoordinates(): array;
}


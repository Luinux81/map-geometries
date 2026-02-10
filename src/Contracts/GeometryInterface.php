<?php

namespace LBCDev\MapGeometries\Contracts;

interface GeometryInterface
{
    /**
     * Convert the geometry to an array representation
     */
    public function toArray(): array;

    /**
     * Convert the geometry to JSON
     */
    public function toJson(): string;

    /**
     * Get the geometry type (marker, polyline, polygon, etc.)
     */
    public function getType(): string;
}


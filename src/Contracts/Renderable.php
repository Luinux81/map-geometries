<?php

namespace LBCDev\MapGeometries\Contracts;

interface Renderable
{
    /**
     * Render the geometry for Leaflet.js
     * Returns JavaScript-compatible array/object structure
     */
    public function render(): array;
}


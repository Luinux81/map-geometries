<?php

namespace LBCDev\MapGeometries;

use LBCDev\MapGeometries\Contracts\GeometryInterface;
use LBCDev\MapGeometries\Contracts\HasCoordinates;
use LBCDev\MapGeometries\Contracts\Renderable;
use Livewire\Wireable;

class Marker implements GeometryInterface, HasCoordinates, Renderable, Wireable
{
    protected float $latitude;

    protected float $longitude;

    protected ?string $label = null;

    protected ?string $tooltip = null;

    protected ?string $icon = null;

    protected ?string $iconColor = null;

    protected array $options = [];

    protected array $metadata = [];

    public function __construct(
        float $latitude,
        float $longitude,
        ?string $label = null,
        ?string $tooltip = null,
        ?string $icon = null,
        ?string $iconColor = null,
        array $options = [],
        array $metadata = []
    ) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->label = $label;
        $this->tooltip = $tooltip;
        $this->icon = $icon;
        $this->iconColor = $iconColor;
        $this->options = $options;
        $this->metadata = $metadata;
    }

    public static function make(
        float $latitude,
        float $longitude,
        ?string $label = null
    ): self {
        return new self($latitude, $longitude, $label);
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getCoordinates(): array
    {
        return [$this->latitude, $this->longitude];
    }

    public function label(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function tooltip(?string $tooltip): self
    {
        $this->tooltip = $tooltip;

        return $this;
    }

    public function getTooltip(): ?string
    {
        return $this->tooltip;
    }

    public function icon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function iconColor(?string $color): self
    {
        $this->iconColor = $color;

        return $this;
    }

    public function getIconColor(): ?string
    {
        return $this->iconColor;
    }

    public function options(array $options): self
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function metadata(array $metadata): self
    {
        $this->metadata = array_merge($this->metadata, $metadata);

        return $this;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function getType(): string
    {
        return 'marker';
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'label' => $this->label,
            'tooltip' => $this->tooltip,
            'icon' => $this->icon,
            'iconColor' => $this->iconColor,
            'options' => $this->options,
            'metadata' => $this->metadata,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function toLivewire(): array
    {
        return $this->toArray();
    }

    public static function fromLivewire($value): self
    {
        return self::make($value['latitude'], $value['longitude'], $value['label'])
            ->tooltip($value['tooltip'])
            ->icon($value['icon'])
            ->iconColor($value['iconColor'])
            ->options($value['options'])
            ->metadata($value['metadata']);
    }

    public function render(): array
    {
        return [
            'lat' => $this->latitude,
            'lng' => $this->longitude,
            'label' => $this->label,
            'tooltip' => $this->tooltip,
            'icon' => $this->icon,
            'iconColor' => $this->iconColor,
            'options' => $this->options,
        ];
    }
}

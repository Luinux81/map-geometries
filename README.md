# Map Geometries

[![Tests](https://github.com/Luinux81/map-geometries/workflows/Tests/badge.svg)](https://github.com/Luinux81/map-geometries/actions)
[![Latest Stable Version](https://poser.pugx.org/lbcdev/map-geometries/v)](https://packagist.org/packages/lbcdev/map-geometries)
[![Total Downloads](https://poser.pugx.org/lbcdev/map-geometries/downloads)](https://packagist.org/packages/lbcdev/map-geometries)
[![License](https://poser.pugx.org/lbcdev/map-geometries/license)](https://packagist.org/packages/lbcdev/map-geometries)

A PHP package for working with map geometries (Markers, Polylines, Polygons, etc.) with full Livewire support.

## Features

- 🎯 **Marker Support**: Create and manage map markers
- 🔄 **Livewire Integration**: Full Wireable support for real-time updates
- 📦 **Collections**: Powerful MarkerCollection with Iterator, Countable, ArrayAccess
- 🎨 **Fluent API**: Chainable methods for clean, readable code
- ✅ **Well Tested**: Comprehensive test suite with 36+ tests
- 📚 **Fully Documented**: Complete PHPDoc and usage examples

## Requirements

- PHP 8.1 or higher
- Composer

## Installation

```bash
composer require lbcdev/map-geometries
```

## Quick Start

### Creating a Marker

```php
use LBCDev\MapGeometries\Marker;

$marker = Marker::make(40.7128, -74.0060, 'New York City')
    ->tooltip('The Big Apple')
    ->iconColor('blue')
    ->icon('custom-icon');
```

### Using MarkerCollection

```php
use LBCDev\MapGeometries\MarkerCollection;

$markers = new MarkerCollection();

$markers->add(
    Marker::make(40.7128, -74.0060, 'New York')
);

$markers->add(
    Marker::make(51.5074, -0.1278, 'London')
);

// Iterate
foreach ($markers as $marker) {
    echo $marker->getLabel();
}

// Count
echo count($markers); // 2

// Access by index
$firstMarker = $markers[0];
```

## API Documentation

### Marker

#### Creation

```php
Marker::make(float $latitude, float $longitude, ?string $label = null): self
```

#### Methods

| Method | Description | Return |
| ------ | ----------- | ------ |
| `label(?string $label)` | Set the marker label | `self` |
| `tooltip(?string $tooltip)` | Set the tooltip (supports HTML) | `self` |
| `icon(?string $icon)` | Set custom icon | `self` |
| `iconColor(?string $color)` | Set icon color | `self` |
| `options(array $options)` | Set custom options | `self` |
| `metadata(array $metadata)` | Set metadata | `self` |
| `getLatitude()` | Get latitude | `float` |
| `getLongitude()` | Get longitude | `float` |
| `getCoordinates()` | Get [lat, lng] | `array` |
| `toArray()` | Convert to array | `array` |
| `toJson()` | Convert to JSON | `string` |

### MarkerCollection

#### Methods of `MarkerCollection`

| Method | Description | Return |
| ------ | ----------- | ------ |
| `add(Marker $marker)` | Add marker to collection | `self` |
| `get(int $index)` | Get marker by index | `Marker\|null` |
| `remove(int $index)` | Remove marker by index | `self` |
| `clear()` | Remove all markers | `self` |
| `all()` | Get all markers | `array` |
| `isEmpty()` | Check if empty | `bool` |
| `count()` | Count markers | `int` |
| `toArray()` | Convert to array | `array` |
| `toJson()` | Convert to JSON | `string` |

## Livewire Integration

Markers are fully compatible with Livewire:

```php
use LBCDev\MapGeometries\Marker;
use Livewire\Component;

class MapComponent extends Component
{
    public Marker $marker;
    
    public function mount()
    {
        $this->marker = Marker::make(40.7128, -74.0060, 'NYC');
    }
    
    public function updateMarker()
    {
        $this->marker->iconColor('red');
    }
}
```

## Testing

```bash
composer test
```

With coverage:

```bash
composer test-coverage
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email <luinux81@gmail.com> instead of using the issue tracker.

## Credits

- [Luinux81](https://github.com/Luinux81)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Related Packages

This package is part of the LBCDev Maps Suite:

- [livewire-maps-core](https://github.com/Luinux81/livewire-maps-core) - Core Livewire map component
- [filament-maps-fields](https://github.com/Luinux81/filament-maps-fields) - Map form fields for Filament
- [filament-maps-widgets](https://github.com/Luinux81/filament-maps-widgets) - Map widgets for Filament panels

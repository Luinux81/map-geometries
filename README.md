# Map Geometries

Geometry classes for maps (Markers, Polylines, Polygons, etc.)

## Installation

```bash
composer require lbcdev/map-geometries
```

## Usage

### Marker

```php
use LBCDev\MapGeometries\Marker;

// Create a simple marker
$marker = Marker::make(40.7128, -74.0060, 'New York');

// With additional properties
$marker = Marker::make(51.5074, -0.1278, 'London')
    ->tooltip('London, United Kingdom')
    ->icon('custom-icon')
    ->iconColor('#FF5733')
    ->options(['draggable' => true])
    ->metadata(['id' => 123]);

// Get coordinates
$lat = $marker->getLatitude();
$lng = $marker->getLongitude();
$coords = $marker->getCoordinates(); // [lat, lng]

// Convert to array
$array = $marker->toArray();

// Render for Leaflet.js
$leafletData = $marker->render();
```

### MarkerCollection

```php
use LBCDev\MapGeometries\Marker;
use LBCDev\MapGeometries\MarkerCollection;

// Create collection
$collection = MarkerCollection::make([
    Marker::make(40.7128, -74.0060, 'New York'),
    Marker::make(51.5074, -0.1278, 'London'),
    Marker::make(48.8566, 2.3522, 'Paris'),
]);

// Add markers
$collection->add(Marker::make(35.6762, 139.6503, 'Tokyo'));

// Iterate
foreach ($collection as $marker) {
    echo $marker->getLabel();
}

// Array access
$firstMarker = $collection[0];
$collection[] = Marker::make(1.0, 1.0);

// Count
$count = count($collection);

// Render all for Leaflet.js
$leafletMarkers = $collection->render();
```

## Testing

```bash
composer test
```

## License

MIT

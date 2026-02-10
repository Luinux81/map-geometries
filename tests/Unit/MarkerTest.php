<?php

namespace LBCDev\MapGeometries\Tests\Unit;

use LBCDev\MapGeometries\Marker;
use PHPUnit\Framework\TestCase;

class MarkerTest extends TestCase
{
    public function test_can_create_marker_with_coordinates(): void
    {
        $marker = new Marker(40.7128, -74.0060);

        $this->assertEquals(40.7128, $marker->getLatitude());
        $this->assertEquals(-74.0060, $marker->getLongitude());
    }

    public function test_can_create_marker_using_make_method(): void
    {
        $marker = Marker::make(51.5074, -0.1278, 'London');

        $this->assertEquals(51.5074, $marker->getLatitude());
        $this->assertEquals(-0.1278, $marker->getLongitude());
        $this->assertEquals('London', $marker->getLabel());
    }

    public function test_can_set_label(): void
    {
        $marker = Marker::make(48.8566, 2.3522)
            ->label('Paris');

        $this->assertEquals('Paris', $marker->getLabel());
    }

    public function test_can_set_tooltip(): void
    {
        $marker = Marker::make(35.6762, 139.6503)
            ->tooltip('Tokyo, Japan');

        $this->assertEquals('Tokyo, Japan', $marker->getTooltip());
    }

    public function test_can_set_icon(): void
    {
        $marker = Marker::make(40.4168, -3.7038)
            ->icon('custom-icon');

        $this->assertEquals('custom-icon', $marker->getIcon());
    }

    public function test_can_set_icon_color(): void
    {
        $marker = Marker::make(52.5200, 13.4050)
            ->iconColor('#FF5733');

        $this->assertEquals('#FF5733', $marker->getIconColor());
    }

    public function test_can_set_options(): void
    {
        $marker = Marker::make(41.9028, 12.4964)
            ->options(['draggable' => true, 'opacity' => 0.8]);

        $this->assertEquals(['draggable' => true, 'opacity' => 0.8], $marker->getOptions());
    }

    public function test_can_merge_options(): void
    {
        $marker = Marker::make(55.7558, 37.6173)
            ->options(['draggable' => true])
            ->options(['opacity' => 0.5]);

        $this->assertEquals(['draggable' => true, 'opacity' => 0.5], $marker->getOptions());
    }

    public function test_can_set_metadata(): void
    {
        $marker = Marker::make(34.0522, -118.2437)
            ->metadata(['id' => 123, 'name' => 'Los Angeles']);

        $this->assertEquals(['id' => 123, 'name' => 'Los Angeles'], $marker->getMetadata());
    }

    public function test_get_coordinates_returns_array(): void
    {
        $marker = Marker::make(37.7749, -122.4194);

        $this->assertEquals([37.7749, -122.4194], $marker->getCoordinates());
    }

    public function test_get_type_returns_marker(): void
    {
        $marker = Marker::make(45.4215, -75.6972);

        $this->assertEquals('marker', $marker->getType());
    }

    public function test_to_array_returns_correct_structure(): void
    {
        $marker = Marker::make(43.6532, -79.3832, 'Toronto')
            ->tooltip('Toronto, Canada')
            ->icon('pin')
            ->iconColor('#0000FF')
            ->options(['draggable' => false])
            ->metadata(['population' => 2930000]);

        $array = $marker->toArray();

        $this->assertIsArray($array);
        $this->assertEquals('marker', $array['type']);
        $this->assertEquals(43.6532, $array['latitude']);
        $this->assertEquals(-79.3832, $array['longitude']);
        $this->assertEquals('Toronto', $array['label']);
        $this->assertEquals('Toronto, Canada', $array['tooltip']);
        $this->assertEquals('pin', $array['icon']);
        $this->assertEquals('#0000FF', $array['iconColor']);
        $this->assertEquals(['draggable' => false], $array['options']);
        $this->assertEquals(['population' => 2930000], $array['metadata']);
    }

    public function test_to_json_returns_valid_json(): void
    {
        $marker = Marker::make(49.2827, -123.1207, 'Vancouver');

        $json = $marker->toJson();

        $this->assertJson($json);
        $decoded = json_decode($json, true);
        $this->assertEquals('marker', $decoded['type']);
        $this->assertEquals(49.2827, $decoded['latitude']);
        $this->assertEquals('Vancouver', $decoded['label']);
    }

    public function test_render_returns_leaflet_compatible_structure(): void
    {
        $marker = Marker::make(45.5017, -73.5673, 'Montreal')
            ->tooltip('Montreal, Quebec')
            ->icon('marker-icon')
            ->iconColor('#FF0000')
            ->options(['draggable' => true]);

        $rendered = $marker->render();

        $this->assertIsArray($rendered);
        $this->assertEquals(45.5017, $rendered['lat']);
        $this->assertEquals(-73.5673, $rendered['lng']);
        $this->assertEquals('Montreal', $rendered['label']);
        $this->assertEquals('Montreal, Quebec', $rendered['tooltip']);
        $this->assertEquals('marker-icon', $rendered['icon']);
        $this->assertEquals('#FF0000', $rendered['iconColor']);
        $this->assertEquals(['draggable' => true], $rendered['options']);
        $this->assertArrayNotHasKey('metadata', $rendered); // metadata should not be in render
    }
}


<?php

namespace LBCDev\MapGeometries\Tests\Unit;

use LBCDev\MapGeometries\Marker;
use LBCDev\MapGeometries\MarkerCollection;
use PHPUnit\Framework\TestCase;

class MarkerCollectionTest extends TestCase
{
    public function test_can_create_empty_collection(): void
    {
        $collection = new MarkerCollection();

        $this->assertCount(0, $collection);
        $this->assertTrue($collection->isEmpty());
    }

    public function test_can_create_collection_with_markers(): void
    {
        $markers = [
            Marker::make(40.7128, -74.0060, 'New York'),
            Marker::make(51.5074, -0.1278, 'London'),
        ];

        $collection = new MarkerCollection($markers);

        $this->assertCount(2, $collection);
        $this->assertFalse($collection->isEmpty());
    }

    public function test_can_create_collection_using_make_method(): void
    {
        $collection = MarkerCollection::make([
            Marker::make(48.8566, 2.3522, 'Paris'),
        ]);

        $this->assertCount(1, $collection);
    }

    public function test_can_add_marker(): void
    {
        $collection = new MarkerCollection();
        $marker = Marker::make(35.6762, 139.6503, 'Tokyo');

        $collection->add($marker);

        $this->assertCount(1, $collection);
    }

    public function test_can_add_multiple_markers(): void
    {
        $collection = new MarkerCollection();

        $collection
            ->add(Marker::make(40.4168, -3.7038, 'Madrid'))
            ->add(Marker::make(52.5200, 13.4050, 'Berlin'))
            ->add(Marker::make(41.9028, 12.4964, 'Rome'));

        $this->assertCount(3, $collection);
    }

    public function test_can_get_marker_by_index(): void
    {
        $marker1 = Marker::make(55.7558, 37.6173, 'Moscow');
        $marker2 = Marker::make(34.0522, -118.2437, 'Los Angeles');

        $collection = MarkerCollection::make([$marker1, $marker2]);

        $this->assertSame($marker1, $collection->get(0));
        $this->assertSame($marker2, $collection->get(1));
        $this->assertNull($collection->get(999));
    }

    public function test_can_remove_marker_by_index(): void
    {
        $collection = MarkerCollection::make([
            Marker::make(37.7749, -122.4194, 'San Francisco'),
            Marker::make(45.4215, -75.6972, 'Ottawa'),
            Marker::make(43.6532, -79.3832, 'Toronto'),
        ]);

        $collection->remove(1);

        $this->assertCount(2, $collection);
        $this->assertEquals('San Francisco', $collection->get(0)->getLabel());
        $this->assertEquals('Toronto', $collection->get(1)->getLabel());
    }

    public function test_can_get_all_markers(): void
    {
        $marker1 = Marker::make(49.2827, -123.1207, 'Vancouver');
        $marker2 = Marker::make(45.5017, -73.5673, 'Montreal');

        $collection = MarkerCollection::make([$marker1, $marker2]);

        $all = $collection->all();

        $this->assertIsArray($all);
        $this->assertCount(2, $all);
        $this->assertSame($marker1, $all[0]);
        $this->assertSame($marker2, $all[1]);
    }

    public function test_can_clear_collection(): void
    {
        $collection = MarkerCollection::make([
            Marker::make(1.0, 1.0),
            Marker::make(2.0, 2.0),
        ]);

        $collection->clear();

        $this->assertCount(0, $collection);
        $this->assertTrue($collection->isEmpty());
    }

    public function test_can_iterate_over_collection(): void
    {
        $collection = MarkerCollection::make([
            Marker::make(10.0, 10.0, 'A'),
            Marker::make(20.0, 20.0, 'B'),
            Marker::make(30.0, 30.0, 'C'),
        ]);

        $labels = [];
        foreach ($collection as $marker) {
            $labels[] = $marker->getLabel();
        }

        $this->assertEquals(['A', 'B', 'C'], $labels);
    }

    public function test_can_access_as_array(): void
    {
        $marker1 = Marker::make(1.0, 1.0, 'First');
        $marker2 = Marker::make(2.0, 2.0, 'Second');

        $collection = new MarkerCollection();
        $collection[] = $marker1;
        $collection[1] = $marker2;

        $this->assertTrue(isset($collection[0]));
        $this->assertTrue(isset($collection[1]));
        $this->assertFalse(isset($collection[2]));
        $this->assertEquals('First', $collection[0]->getLabel());
        $this->assertEquals('Second', $collection[1]->getLabel());
    }

    public function test_can_unset_array_access(): void
    {
        $collection = MarkerCollection::make([
            Marker::make(1.0, 1.0),
            Marker::make(2.0, 2.0),
            Marker::make(3.0, 3.0),
        ]);

        unset($collection[1]);

        $this->assertCount(2, $collection);
    }

    public function test_array_access_throws_exception_for_non_marker(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $collection = new MarkerCollection();
        $collection[] = 'not a marker';
    }

    public function test_get_type_returns_marker_collection(): void
    {
        $collection = new MarkerCollection();

        $this->assertEquals('marker-collection', $collection->getType());
    }

    public function test_to_array_returns_correct_structure(): void
    {
        $collection = MarkerCollection::make([
            Marker::make(1.0, 1.0, 'A'),
            Marker::make(2.0, 2.0, 'B'),
        ]);

        $array = $collection->toArray();

        $this->assertIsArray($array);
        $this->assertEquals('marker-collection', $array['type']);
        $this->assertEquals(2, $array['count']);
        $this->assertIsArray($array['markers']);
        $this->assertCount(2, $array['markers']);
    }

    public function test_to_json_returns_valid_json(): void
    {
        $collection = MarkerCollection::make([
            Marker::make(10.0, 20.0, 'Test'),
        ]);

        $json = $collection->toJson();

        $this->assertJson($json);
        $decoded = json_decode($json, true);
        $this->assertEquals('marker-collection', $decoded['type']);
        $this->assertEquals(1, $decoded['count']);
    }

    public function test_render_returns_array_of_rendered_markers(): void
    {
        $collection = MarkerCollection::make([
            Marker::make(1.0, 2.0, 'First'),
            Marker::make(3.0, 4.0, 'Second'),
        ]);

        $rendered = $collection->render();

        $this->assertIsArray($rendered);
        $this->assertCount(2, $rendered);
        $this->assertEquals(1.0, $rendered[0]['lat']);
        $this->assertEquals(2.0, $rendered[0]['lng']);
        $this->assertEquals('First', $rendered[0]['label']);
        $this->assertEquals(3.0, $rendered[1]['lat']);
        $this->assertEquals(4.0, $rendered[1]['lng']);
        $this->assertEquals('Second', $rendered[1]['label']);
    }
}

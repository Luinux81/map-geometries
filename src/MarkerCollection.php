<?php

namespace LBCDev\MapGeometries;

use ArrayAccess;
use Countable;
use Iterator;
use LBCDev\MapGeometries\Contracts\GeometryInterface;
use LBCDev\MapGeometries\Contracts\Renderable;

class MarkerCollection implements GeometryInterface, Renderable, Countable, Iterator, ArrayAccess
{
    /** @var Marker[] */
    protected array $markers = [];

    protected int $position = 0;

    public function __construct(array $markers = [])
    {
        foreach ($markers as $marker) {
            $this->add($marker);
        }
    }

    public static function make(array $markers = []): self
    {
        return new self($markers);
    }

    public function add(Marker $marker): self
    {
        $this->markers[] = $marker;

        return $this;
    }

    public function remove(int $index): self
    {
        if (isset($this->markers[$index])) {
            unset($this->markers[$index]);
            $this->markers = array_values($this->markers); // Re-index
        }

        return $this;
    }

    public function get(int $index): ?Marker
    {
        return $this->markers[$index] ?? null;
    }

    public function all(): array
    {
        return $this->markers;
    }

    public function isEmpty(): bool
    {
        return empty($this->markers);
    }

    public function clear(): self
    {
        $this->markers = [];
        $this->position = 0;

        return $this;
    }

    // Countable
    public function count(): int
    {
        return count($this->markers);
    }

    // Iterator
    public function current(): mixed
    {
        return $this->markers[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->markers[$this->position]);
    }

    // ArrayAccess
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->markers[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->markers[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof Marker) {
            throw new \InvalidArgumentException('Value must be an instance of Marker');
        }

        if ($offset === null) {
            $this->markers[] = $value;
        } else {
            $this->markers[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->markers[$offset]);
        $this->markers = array_values($this->markers); // Re-index
    }

    // GeometryInterface
    public function getType(): string
    {
        return 'marker-collection';
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'count' => $this->count(),
            'markers' => array_map(fn (Marker $marker) => $marker->toArray(), $this->markers),
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    // Renderable
    public function render(): array
    {
        return array_map(fn (Marker $marker) => $marker->render(), $this->markers);
    }
}


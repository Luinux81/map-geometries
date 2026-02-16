# Changelog

All notable changes to `map-geometries` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2026-02-16

### Added

- Initial stable release
- `Marker` class with fluent API
- `MarkerCollection` class with Iterator, Countable, ArrayAccess interfaces
- Full Livewire Wireable support
- Comprehensive test suite (36 tests)
- Complete PHPDoc documentation

### Interfaces

- `GeometryInterface` - Base contract for all geometries
- `HasCoordinates` - Contract for coordinate-based geometries
- `Renderable` - Contract for renderable geometries

### Features

- Marker creation with `Marker::make(lat, lng, label)`
- Fluent API methods: `label()`, `tooltip()`, `icon()`, `iconColor()`, `options()`, `metadata()`
- Collection operations: `add()`, `get()`, `remove()`, `clear()`, `all()`
- JSON serialization support
- Livewire wire support for real-time updates

[Unreleased]: https://github.com/Luinux81/map-geometries/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/Luinux81/map-geometries/releases/tag/v1.0.0

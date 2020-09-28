# Changelog

All notable changes to `laravel-fulltext` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## Unreleased

* Nothing

## [0.19.0] - 2020-04-30

### Added

New feature which you can enable in the config:

* exclude_feature_enabled
This feature excludes some rows from being returned. Enable this when you have a flag in your model which determines whether this record must be returned in search queries or not. By default this feature is disabled.

* exclude_records_column_name
The column name for that property (which acts as a flag). This must match the exact column name at the table.

## [0.18.0] - 2020-03-06

### Added

* Added support for Laravel 7.

## [0.17.0] - 2019-10-13

### Added

* Added support for Laravel 6.
* Database connection can now be set in the configuration (db_connection).

### Changed

* Changed namespace from `Swis\LaravelFulltext` to `Swis\Laravel\Fulltext`.

## [0.16.0] - 2019-03-20

### Added

* Added support for Laravel 5.8.

### Changed

* Dropped Laravel <5.5 support.
* Dropped PHP <7.1 support.

## [0.15.0] - 2019-01-28

### Fixed

* Fixed rogue terms when parsing fulltext queries with leading operator (thanks @JaZo)

## [0.14.0] - 2018-09-21

### Changed

* Run tests on multiple PHP and Laravel versions.
* Restrict Laravel versions to `^5.1,<5.8`.
* Rename tests namespace.
* Improve README and other documentation.

### Fixed

* Add missing dependency to composer.json.

### Added

* Code style checker/fixer.
* Add CHANGELOG.

### Removed

* Drop PHP 5.6 support.

## [0.13.0] - 2018-08-30

### Fixed

* Correctly retrieve relationship items when relationship is single item.

## [0.12.2] - 2018-06-22

### Fixed

* Trim string so search strings ending in special characters don't break.

## [0.12.1] - 2018-06-14

### Fixed

* Always remove operators from search query.

## [0.12] - 2018-05-28

### Fixed

* Fixed bug in wildcard usage.

## [0.11] - 2018-05-14

### Changed

* Allow searching for empty string in `searchQuery` method so the package doesn't throw a query exception.

### Added

* Added basic `.gitignore`.

## [0.10] - 2018-05-09

### Added

* Package discovery added.

## [0.9] - 2017-11-10

### Changed

* Set `enable_wildcards=true` as default

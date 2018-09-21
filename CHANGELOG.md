# Changelog

All notable changes to `laravel-fulltext` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [0.14.0] - 2018-09-21

### Changed

* Run tests on multiple PHP and Laravel versions.
* Restrict Laravel versions to `^5.1,<5.8`.
* Rename tests namespace.
* Improve README and other documentation.

## Fixed

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

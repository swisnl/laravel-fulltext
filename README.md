# Laravel fulltext index and search

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Total Downloads][ico-downloads]][link-downloads]
[![Made by SWIS][ico-swis]][link-swis]

This package creates a MySQL fulltext index for models and enables you to search through those.

## Install

1. Install with composer ``composer require swisnl/laravel-fulltext``.
2. Publish migrations and config ``php artisan vendor:publish --tag=laravel-fulltext``
3. Migrate the database ``php artisan migrate``

> Only if you are on Laravel 5.4 or lower will you need to install the service provider ``Swis\LaravelFulltext\FulltextServiceProvider::class,`` in ``config/app.php``


## Usage

The package uses a model observer to update the index when models change. If you want to run a full index you can use the console commands.

### Models

Add the ``Indexable`` trait to the model you want to have indexed and define the columns you'd like to index as title and content.

#### Example
```
class Country extends Model
{

    use \Swis\LaravelFulltext\Indexable;

    protected $indexContentColumns = ['biographies.name', 'political_situation', 'elections'];
    protected $indexTitleColumns = ['name', 'governmental_type'];

}
```

You can use a dot notitation to query relationships for the model, like ``biographies.name``.


### Searching 

You can search using the Search class.

```
$search = new \Swis\LaravelFulltext\Search();
$search->run('europe');
```

This will return a Collection of ``\Swis\LaravelFulltext\IndexedRecord`` which contain the models in the Polymorphic relation ``indexable``.

If you only want to search a certain model you can use ``$search->runForClass('europe', Country::class);``. This will only return results from that model.


### Commands


#### laravel-fulltext:all

Index all models for a certain class
```
 php artisan  laravel-fulltext:all
 
Usage:
  laravel-fulltext:all <model_class>

Arguments:
  model_class           Classname of the model to index

```

#### Example

``php artisan  laravel-fulltext:all \\App\\Models\\Country``

#### laravel-fulltext:one

```

Usage:
  laravel-fulltext:one <model_class> <id>

Arguments:
  model_class           Classname of the model to index
  id                    ID of the model to index

```

#### Example

`` php artisan  laravel-fulltext:one \\App\\Models\\Country 4 ``


## Options

### weight.title weight.content

Results on ``title`` or ``content`` are weighted in the results. Search result score is multiplied by the weight in this config 

### enable_wildcards

Enable wildcard after words. So when searching for for example  ``car`` it will also match ``carbon``. 

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email security@swis.nl instead of using the issue tracker.

## Credits

- [Björn Brala][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## SWIS

[SWIS][link-swis] is a web agency from Leiden, the Netherlands. We love working with open source software.

[ico-version]: https://img.shields.io/packagist/v/swisnl/laravel-fulltext.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/swisnl/laravel-fulltext/master.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/swisnl/laravel-fulltext.svg?style=flat-square
[ico-swis]: https://img.shields.io/badge/%F0%9F%9A%80-made%20by%20SWIS-%23D9021B.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/swisnl/laravel-fulltext
[link-travis]: https://travis-ci.org/swisnl/laravel-fulltext
[link-downloads]: https://packagist.org/packages/swisnl/laravel-fulltext
[link-author]: https://github.com/swisnl
[link-contributors]: ../../contributors
[link-swis]: https://www.swis.nl

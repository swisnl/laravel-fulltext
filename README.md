# Laravel fulltext index and search

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Buy us a tree][ico-treeware]][link-treeware]
[![Build Status][ico-github-actions]][link-github-actions]
[![Total Downloads][ico-downloads]][link-downloads]
[![Made by SWIS][ico-swis]][link-swis]

This package creates a MySQL fulltext index for models and enables you to search through those.

## Install

1. Install with composer ``composer require swisnl/laravel-fulltext``
2. Publish migrations and config ``php artisan vendor:publish --tag=laravel-fulltext``
3. Migrate the database ``php artisan migrate``


## Usage

The package uses a model observer to update the index when models change. If you want to run a full index you can use the console commands.

### Models

Add the ``Indexable`` trait to the model you want to have indexed and define the columns you'd like to index as title and content.

#### Example

```php
class Country extends Model implements \Swis\Laravel\Fulltext\Contracts\Indexable
{

    use \Swis\Laravel\Fulltext\Concerns\HasIndexation;

    protected $indexContentColumns = ['biographies.name', 'political_situation', 'elections'];
    protected $indexTitleColumns = ['name', 'governmental_type'];

}
```

You can use a dot notation to query relationships for the model, like ``biographies.name``.


### Searching

You can search using the Search class.

```php
$search = new \Swis\Laravel\Fulltext\Search();
$search->run('europe');
```

This will return a Collection of ``\Swis\Laravel\Fulltext\IndexedRecord`` which contain the models in the Polymorphic relation ``indexable``.

If you only want to search a certain model you can use ``$search->runForClass('europe', Country::class);``. This will only return results from that model.


### Artisan Commands


#### laravel-fulltext:all

Index all models for a certain class.
```bash
php artisan laravel-fulltext:all \\App\\Models\\Country
```

#### laravel-fulltext:one
Index a single model of a certain class.
```bash
php artisan laravel-fulltext:one \\App\\Models\\Country 4
```


## Options

### db_connection

Choose the database connection to use, defaults to the default database connection. When you are NOT using the default database connection, this MUST be set before running the migration to work correctly.

### weight.title weight.content

Results on ``title`` or ``content`` are weighted in the results. Search result score is multiplied by the weight in this config.

### limit_results

Limit the amount of results returned after searching. Use `0` for no limit.

### enable_wildcards

Enable wildcard after words. So when searching for example  ``car`` it will also match ``carbon``.

### exclude_feature_enabled

This feature excludes some rows from being returned. Enable this when you have a flag in your model which determines whether this record must be returned in search queries or not. By default this feature is disabled.

### exclude_records_column_name

The column name for that property (which acts as a flag). This must match the exact column name at the table.

#### An example of using this feature

If you have a blog and then added this search functionality to your blog to search through your blog posts. Sometimes you do not want some posts to appear in the search result, for example when a post is not published yet. This feature helps you to do it.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

```bash
composer test
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

This package is [Treeware](https://treeware.earth). If you use it in production, then we ask that you [**buy the world a tree**][link-treeware] to thank us for our work. By contributing to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.

## SWIS :heart: Open Source

[SWIS][link-swis] is a web agency from Leiden, the Netherlands. We love working with open source software.

[ico-version]: https://img.shields.io/packagist/v/swisnl/laravel-fulltext.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-treeware]: https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen.svg?style=flat-square
[ico-github-actions]: https://img.shields.io/github/actions/workflow/status/swisnl/laravel-fulltext/tests.yml?label=tests&branch=master&style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/swisnl/laravel-fulltext.svg?style=flat-square
[ico-swis]: https://img.shields.io/badge/%F0%9F%9A%80-made%20by%20SWIS-%230737A9.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/swisnl/laravel-fulltext
[link-github-actions]: https://github.com/swisnl/laravel-fulltext/actions/workflows/tests.yml
[link-downloads]: https://packagist.org/packages/swisnl/laravel-fulltext
[link-treeware]: https://plant.treeware.earth/swisnl/laravel-fulltext
[link-author]: https://github.com/swisnl
[link-contributors]: ../../contributors
[link-swis]: https://www.swis.nl

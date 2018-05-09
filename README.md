# Laravel fulltext index and search

This package creates a MySQL fulltext index for models and enables you to search through those.

[![Build Status](https://travis-ci.org/swisnl/laravel-fulltext.svg?branch=master)](https://travis-ci.org/swisnl/laravel-fulltext)

## Installation

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

<?php

namespace Swis\LaravelFulltext;

use Illuminate\Support\ServiceProvider;
use Swis\LaravelFulltext\Commands\Index;
use Swis\LaravelFulltext\Commands\IndexOne;
use Swis\LaravelFulltext\Commands\Install;
use Swis\LaravelFulltext\Commands\UnindexOne;

class FulltextServiceProvider extends ServiceProvider
{

    protected $commands = [
      Index::class,
      IndexOne::class,
      UnindexOne::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
          __DIR__.'/../config/laravel-fulltext.php',
          'laravel-fulltext'
        );

        if ($this->app->runningInConsole()) {

            $this->publishes(
              [
                __DIR__.'/../config/laravel-fulltext.php' => config_path('laravel-fulltext.php'),
              ],
              'laravel-fulltext'
            );

            $this->publishes(
              [
                __DIR__.'/../database/migrations' => database_path('migrations'),
              ],
              'laravel-fulltext'
            );

            $this->commands($this->commands);
        }

        $this->app->bind(
          SearchInterface::class,
          Search::class
        );
    }
}

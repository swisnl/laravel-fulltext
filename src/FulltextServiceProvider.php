<?php

namespace Swis\Laravel\Fulltext;

use Illuminate\Support\ServiceProvider;
use Swis\Laravel\Fulltext\Commands\Index;
use Swis\Laravel\Fulltext\Commands\IndexOne;
use Swis\Laravel\Fulltext\Commands\UnindexOne;

class FulltextServiceProvider extends ServiceProvider
{
    /**
     * @var array<string>
     */
    protected array $commands = [
        Index::class,
        IndexOne::class,
        UnindexOne::class,
    ];

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-fulltext.php',
            'laravel-fulltext'
        );

        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__.'/../config/laravel-fulltext.php' => $this->app->configPath('laravel-fulltext.php'),
                ],
                'laravel-fulltext'
            );

            $this->publishes(
                [
                    __DIR__.'/../database/migrations' => $this->app->databasePath('migrations'),
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

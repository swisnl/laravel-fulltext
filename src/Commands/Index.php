<?php

namespace Swis\Laravel\Fulltext\Commands;

use Illuminate\Console\Command;
use InvalidArgumentException;
use Swis\Laravel\Fulltext\Indexer;

class Index extends Command
{
    protected $signature = 'laravel-fulltext:all {model_class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build the searchindex';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $modelClass = $this->argument('model_class');
        if (!is_string($modelClass)) {
            throw new InvalidArgumentException('Model class must be a string');
        }

        $indexer = new Indexer;
        $indexer->indexAllByClass($modelClass);

        return self::SUCCESS;
    }
}

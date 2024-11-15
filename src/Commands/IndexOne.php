<?php

namespace Swis\Laravel\Fulltext\Commands;

use Illuminate\Console\Command;
use InvalidArgumentException;
use Swis\Laravel\Fulltext\Indexer;

class IndexOne extends Command
{
    protected $signature = 'laravel-fulltext:one {model_class} {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the searchindex for a single record';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $modelClass = $this->argument('model_class');
        if (! is_string($modelClass)) {
            throw new InvalidArgumentException('Model class must be a string');
        }

        $id = $this->argument('id');
        if (! is_string($id)) {
            throw new InvalidArgumentException('ID must be a string or an integer');
        }

        $indexer = new Indexer;
        $indexer->indexOneByClass($modelClass, $id);

        return self::SUCCESS;
    }
}

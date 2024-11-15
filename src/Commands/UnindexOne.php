<?php

namespace Swis\Laravel\Fulltext\Commands;

use Illuminate\Console\Command;
use InvalidArgumentException;
use Swis\Laravel\Fulltext\Indexer;

class UnindexOne extends Command
{
    protected $signature = 'laravel-fulltext:unindex {model_class} {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove a single record from the searchindex';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $modelClass = $this->argument('model_class');
        if (!is_string($modelClass)) {
            throw new InvalidArgumentException('Model class must be a string');
        }

        $id = $this->argument('id');
        if (!is_string($id)) {
            throw new InvalidArgumentException('ID must be a string or an integer');
        }

        $indexer = new Indexer;
        $indexer->unIndexOneByClass($modelClass, $id);

        return self::SUCCESS;
    }
}

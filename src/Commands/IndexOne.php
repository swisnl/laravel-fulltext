<?php

namespace Swis\Laravel\Fulltext\Commands;

use Illuminate\Console\Command;
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
        $indexer = new Indexer;
        $indexer->indexOneByClass($this->argument('model_class'), $this->argument('id'));

        return self::SUCCESS;
    }
}

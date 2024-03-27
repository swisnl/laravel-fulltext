<?php

namespace Swis\Laravel\Fulltext\Commands;

use Illuminate\Console\Command;
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
    public function handle()
    {
        $indexer = new Indexer();
        $indexer->unIndexOneByClass($this->argument('model_class'), $this->argument('id'));
    }
}

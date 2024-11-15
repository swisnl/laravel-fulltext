<?php

namespace Swis\Laravel\Fulltext\Commands;

use Illuminate\Console\Command;
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
        $indexer = new Indexer;
        $indexer->indexAllByClass($this->argument('model_class'));

        return self::SUCCESS;
    }
}

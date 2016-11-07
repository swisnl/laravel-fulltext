<?php
namespace Swis\LaravelFulltext\Commands;

use Illuminate\Console\Command;
use Swis\LaravelFulltext\Indexer;

class IndexOne extends Command {

    protected $signature = 'laravel-fulltext:one {model_class} {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the searchindex for a single record';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $indexer = new Indexer();
        $indexer->indexOneByClass($this->argument('model_class'), $this->argument('id'));
    }
}

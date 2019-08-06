<?php
namespace Swis\LaravelFulltext;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class IndexedRecord extends Model
{
    protected $table = 'laravel_fulltext';

    public function __construct()
    {
        parent::__construct();
        $this->connection = Config::get('laravel-fulltext.db_connection', config('database.default'));
    }

    public function indexable()
    {
        return $this->morphTo();
    }

    public function updateIndex()
    {
        $this->setAttribute('indexed_title', $this->indexable->getIndexTitle());
        $this->setAttribute('indexed_content', $this->indexable->getIndexContent());
        $this->save();
    }
}

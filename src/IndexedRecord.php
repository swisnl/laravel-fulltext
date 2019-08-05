<?php
namespace Swis\LaravelFulltext;

use Illuminate\Database\Eloquent\Model;

class IndexedRecord extends Model
{
    protected $table = 'laravel_fulltext';

    public function __construct()
    {
        parent::__construct();
        $this->connection = config('laravel-fulltext.db_connection');
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

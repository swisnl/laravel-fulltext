<?php
namespace Swis\LaravelFulltext;

use Illuminate\Database\Eloquent\Model;

class IndexedRecord extends Model {

    protected $table = 'laravel_fulltext';

    public function indexable(){
        return $this->morphTo();
    }

    public function updateIndex(){
        $this->setAttribute('indexed_title', $this->indexable->getIndexTitle());
        $this->setAttribute('indexed_content', $this->indexable->getIndexContent());
        $this->save();
    }
}

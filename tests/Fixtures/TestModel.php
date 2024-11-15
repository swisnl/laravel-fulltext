<?php

namespace Swis\Laravel\Fulltext\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Swis\Laravel\Fulltext\Contracts\Indexable;

class TestModel extends Model implements Indexable
{
    use \Swis\Laravel\Fulltext\Concerns\HasIndexation;

    public $id = 1;

    public function searchableAs()
    {
        return 'table';
    }

    public function getKey()
    {
        return $this->id;
    }

    public function toSearchableArray()
    {
        return ['id' => 1];
    }
}

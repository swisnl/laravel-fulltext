<?php

namespace Tests\Fixtures;

use Swis\LaravelFulltext\Indexable;

class IndexableTestModel extends TestModel
{
    use Indexable;

    public $indexRecord;
}

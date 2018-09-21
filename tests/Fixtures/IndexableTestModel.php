<?php

namespace Swis\LaravelFulltext\Tests\Fixtures;

use Swis\LaravelFulltext\Indexable;

class IndexableTestModel extends TestModel
{
    use Indexable;

    public $indexRecord;
}

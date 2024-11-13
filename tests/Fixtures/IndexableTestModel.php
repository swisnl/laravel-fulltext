<?php

namespace Swis\Laravel\Fulltext\Tests\Fixtures;

use Swis\Laravel\Fulltext\Concerns\Indexable;

class IndexableTestModel extends TestModel
{
    use Indexable;

    public $indexRecord;
}

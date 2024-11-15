<?php

namespace Swis\Laravel\Fulltext\Tests\Fixtures;

use Swis\Laravel\Fulltext\Concerns\HasIndexation;

class IndexableTestModel extends TestModel
{
    use HasIndexation;

    public $indexRecord;
}

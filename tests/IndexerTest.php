<?php

namespace Swis\LaravelFulltext\Tests;

use Mockery;
use Swis\LaravelFulltext\Indexer;
use Swis\LaravelFulltext\Tests\Fixtures\TestModel;

class IndexerTest extends AbstractTestCase
{
    public function test_index_model(){
        $indexer = new Indexer();
        $model = Mockery::mock(TestModel::class);
        $model->shouldReceive('indexRecord');
        $indexer->indexModel($model);
    }
}

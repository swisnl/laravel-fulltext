<?php

namespace Swis\Laravel\Fulltext\Tests;

use Mockery;
use Swis\Laravel\Fulltext\IndexedRecord;
use Swis\Laravel\Fulltext\Tests\Fixtures\IndexableTestModel;

class IndexableTest extends AbstractTestCase
{
    public function test_indexed_record_receives_update_index()
    {
        $indexedRecord = Mockery::mock(IndexedRecord::class);
        $indexedRecord->shouldReceive('updateIndex');

        $model = new IndexableTestModel();
        $model->indexedRecord = $indexedRecord;
        $model->indexRecord();
    }

    public function test_indexed_record_receives_delete()
    {
        $indexedRecord = Mockery::mock(IndexedRecord::class);
        $indexedRecord->shouldReceive('delete');

        $model = new IndexableTestModel();
        $model->indexedRecord = $indexedRecord;
        $model->unIndexRecord();
    }
}

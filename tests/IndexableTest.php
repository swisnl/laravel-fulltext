<?php

namespace Swis\Laravel\Fulltext\Tests;

use Swis\Laravel\Fulltext\IndexedRecord;
use Swis\Laravel\Fulltext\Tests\Fixtures\IndexableTestModel;

class IndexableTest extends AbstractTestCase
{
    public function testIndexedRecordReceivesUpdateIndex()
    {
        $indexedRecord = \Mockery::mock(IndexedRecord::class);
        $indexedRecord->shouldReceive('updateIndex')->once();

        $model = new IndexableTestModel;
        $model->indexedRecord = $indexedRecord;
        $model->indexRecord();
    }

    public function testIndexedRecordReceivesDelete()
    {
        $indexedRecord = \Mockery::mock(IndexedRecord::class);
        $indexedRecord->shouldReceive('delete')->once();

        $model = new IndexableTestModel;
        $model->indexedRecord = $indexedRecord;
        $model->unIndexRecord();
    }
}

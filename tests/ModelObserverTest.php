<?php

namespace Tests;

use Mockery;
use Swis\LaravelFulltext\ModelObserver;

class ModelObserverTest extends AbstractTestCase
{
    public function test_created_handler_indexes_model()
    {
        $observer = new ModelObserver;
        $model = Mockery::mock();
        $model->shouldReceive('indexRecord');
        $observer->created($model);
    }

    public function test_created_handler_doesnt_index_model_when_disabled()
    {
        $observer = new ModelObserver;
        $model = Mockery::mock();
        $observer->disableSyncingFor(get_class($model));
        $model->shouldReceive('indexRecord')->never();
        $observer->created($model);
    }

    public function test_updated_handler_indexes_model()
    {
        $observer = new ModelObserver;
        $model = Mockery::mock();
        $model->shouldReceive('indexRecord');
        $observer->updated($model);
    }

    public function test_deleted_handler_makes_unindexes_model()
    {
        $observer = new ModelObserver;
        $model = Mockery::mock();
        $model->shouldReceive('unIndexRecord');
        $observer->deleted($model);
    }

    public function test_restored_handler_indexes_model()
    {
        $observer = new ModelObserver;
        $model = Mockery::mock();
        $model->shouldReceive('indexRecord');
        $observer->restored($model);
    }
}

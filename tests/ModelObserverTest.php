<?php

namespace Swis\Laravel\Fulltext\Tests;

use Swis\Laravel\Fulltext\ModelObserver;

class ModelObserverTest extends AbstractTestCase
{
    public function testCreatedHandlerIndexesModel()
    {
        $observer = new ModelObserver;
        $model = \Mockery::mock();
        $model->shouldReceive('indexRecord');
        $observer->created($model);
    }

    public function testCreatedHandlerDoesntIndexModelWhenDisabled()
    {
        $observer = new ModelObserver;
        $model = \Mockery::mock();
        $observer->disableSyncingFor(get_class($model));
        $model->shouldReceive('indexRecord')->never();
        $observer->created($model);
    }

    public function testUpdatedHandlerIndexesModel()
    {
        $observer = new ModelObserver;
        $model = \Mockery::mock();
        $model->shouldReceive('indexRecord');
        $observer->updated($model);
    }

    public function testDeletedHandlerMakesUnindexesModel()
    {
        $observer = new ModelObserver;
        $model = \Mockery::mock();
        $model->shouldReceive('unIndexRecord');
        $observer->deleted($model);
    }

    public function testRestoredHandlerIndexesModel()
    {
        $observer = new ModelObserver;
        $model = \Mockery::mock();
        $model->shouldReceive('indexRecord');
        $observer->restored($model);
    }
}

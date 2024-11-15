<?php

namespace Swis\Laravel\Fulltext\Tests;

use Swis\Laravel\Fulltext\Contracts\Indexable;
use Swis\Laravel\Fulltext\ModelObserver;

class ModelObserverTest extends AbstractTestCase
{
    public function testCreatedHandlerIndexesModel()
    {
        $observer = new ModelObserver;
        $model = \Mockery::mock(Indexable::class);
        $model->shouldReceive('indexRecord')->once();
        $observer->created($model);
    }

    public function testCreatedHandlerDoesntIndexModelWhenDisabled()
    {
        $observer = new ModelObserver;
        $model = \Mockery::mock(Indexable::class);
        $observer->disableSyncingFor(get_class($model));
        $model->shouldReceive('indexRecord')->never();
        $observer->created($model);
        $observer->enableSyncingFor(get_class($model));
    }

    public function testUpdatedHandlerIndexesModel()
    {
        $observer = new ModelObserver;
        $model = \Mockery::mock(Indexable::class);
        $model->shouldReceive('indexRecord')->once();
        $observer->updated($model);
    }

    public function testDeletedHandlerMakesUnindexesModel()
    {
        $observer = new ModelObserver;
        $model = \Mockery::mock(Indexable::class);
        $model->shouldReceive('unIndexRecord')->once();
        $observer->deleted($model);
    }

    public function testRestoredHandlerIndexesModel()
    {
        $observer = new ModelObserver;
        $model = \Mockery::mock(Indexable::class);
        $model->shouldReceive('indexRecord')->once();
        $observer->restored($model);
    }
}

<?php

namespace Swis\Laravel\Fulltext;

use Illuminate\Database\Eloquent\Model;
use Swis\Laravel\Fulltext\Contracts\Indexable;

class Indexer
{
    public function indexModel(Indexable $indexable): void
    {
        $indexable->indexRecord();
    }

    public function unIndexOneByClass(string $class, string|int $id): void
    {
        if (! is_subclass_of($class, Model::class)) {
            return;
        }

        $record = IndexedRecord::query()
            ->where('indexable_id', $id)
            ->where('indexable_type', (new $class)->getMorphClass());

        if ($record->exists()) {
            $record->delete();
        }
    }

    public function indexOneByClass(string $class, string|int $id): void
    {
        if (! is_subclass_of($class, Model::class)) {
            return;
        }

        $model = call_user_func([$class, 'find'], $id);
        if ($model instanceof Indexable) {
            $this->indexModel($model);
        }
    }

    public function indexAllByClass(string $class): void
    {
        if (! is_subclass_of($class, Model::class)) {
            return;
        }

        $model = new $class;
        if ($model instanceof Indexable) {
            $model->newQuery()->chunk(100, function ($chunk) {
                foreach ($chunk as $modelRecord) {
                    $this->indexModel($modelRecord);
                }
            });
        }
    }
}

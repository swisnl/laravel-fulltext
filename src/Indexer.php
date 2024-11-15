<?php

namespace Swis\Laravel\Fulltext;

use Swis\Laravel\Fulltext\Contracts\Indexable;

class Indexer
{
    public function indexModel(Indexable $indexable): void
    {
        $indexable->indexRecord();
    }

    public function unIndexOneByClass(string $class, string|int $id): void
    {
        $record = IndexedRecord::query()
            ->where('indexable_id', $id)->where('indexable_type', (new $class)->getMorphClass());

        if ($record->exists()) {
            $record->delete();
        }
    }

    public function indexOneByClass(string $class, string|int $id): void
    {
        $model = call_user_func([$class, 'find'], $id);
        if (in_array(Indexable::class, class_uses($model), true)) {
            $this->indexModel($model);
        }
    }

    public function indexAllByClass(string $class): void
    {
        $model = new $class;
        $self = $this;
        if (in_array(Indexable::class, class_uses($model), true)) {
            $model->chunk(100, function ($chunk) use ($self) {
                foreach ($chunk as $modelRecord) {
                    $self->indexModel($modelRecord);
                }
            });
        }
    }
}

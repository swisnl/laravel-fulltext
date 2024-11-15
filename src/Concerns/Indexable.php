<?php

namespace Swis\Laravel\Fulltext\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Swis\Laravel\Fulltext\IndexedRecord;
use Swis\Laravel\Fulltext\ModelObserver;

/**
 * @property IndexedRecord|null $indexedRecord
 */
trait Indexable
{
    /**
     * Boot the trait.
     */
    public static function bootIndexable(): void
    {
        static::observe(new ModelObserver);
    }

    public function getIndexContent(): string
    {
        return $this->getIndexDataFromColumns($this->indexContentColumns);
    }

    public function getIndexTitle(): string
    {
        return $this->getIndexDataFromColumns($this->indexTitleColumns);
    }

    /**
     * @return MorphOne<IndexedRecord, \Swis\Laravel\Fulltext\Contracts\Indexable>
     */
    public function indexedRecord(): MorphOne
    {
        return $this->morphOne(IndexedRecord::class, 'indexable');
    }

    public function indexRecord(): void
    {
        if ($this->indexedRecord === null) {
            $this->indexedRecord = new IndexedRecord;
            $this->indexedRecord->indexable()->associate($this);
        }
        $this->indexedRecord->updateIndex();
    }

    public function unIndexRecord(): void
    {
        if ($this->indexedRecord !== null) {
            $this->indexedRecord->delete();
        }
    }

    protected function getIndexDataFromColumns($columns): string
    {
        $indexData = [];
        foreach ($columns as $column) {
            $indexValue = data_get($this, $column);

            if (is_array($indexValue)) {
                $indexValue = implode(' ', array_filter($indexValue));
            }

            $indexData[] = $indexValue;
        }

        return implode(' ', array_filter($indexData));
    }
}

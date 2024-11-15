<?php

namespace Swis\Laravel\Fulltext\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Swis\Laravel\Fulltext\IndexedRecord;

interface Indexable
{
    public function getIndexContent(): string;

    public function getIndexTitle(): string;

    public function indexRecord(): void;

    public function unIndexRecord(): void;

    /**
     * @return MorphOne<IndexedRecord, Model>
     */
    public function indexedRecord(): MorphOne;
}

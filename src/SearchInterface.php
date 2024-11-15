<?php

namespace Swis\Laravel\Fulltext;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface SearchInterface
{
    /**
     * @return Collection<int, IndexedRecord>
     */
    public function run(string $search): Collection;

    /**
     * @return Collection<int, IndexedRecord>
     */
    public function runForClass(string $search, string $class): Collection;

    /**
     * @return Builder<IndexedRecord>
     */
    public function searchQuery(string $search): Builder;
}

<?php

namespace Swis\Laravel\Fulltext\Contracts;

interface Indexable
{
    public function getIndexContent(): string;

    public function getIndexTitle(): string;

    public function indexRecord(): void;

    public function unIndexRecord(): void;

    public function indexedRecord();
}

<?php

namespace Swis\Laravel\Fulltext;

interface SearchInterface
{
    public function run(string $search);

    public function runForClass(string $search, string $class);

    public function searchQuery(string $search);
}

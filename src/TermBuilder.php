<?php

namespace Swis\Laravel\Fulltext;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class TermBuilder
{
    /**
     * @return Collection<int, non-falsy-string>
     */
    public static function terms(string $search): Collection
    {
        $wildcards = Config::get('laravel-fulltext.enable_wildcards');

        // Remove every boolean operator (+, -, > <, ( ), ~, *, ", @distance) from the search query
        // else we will break the MySQL query.
        $search = trim(preg_replace('/[+\-><\(\)~*\"@]+/', ' ', $search) ?: '');

        $terms = collect(preg_split('/[\s,]+/', $search) ?: [])->filter();

        if ($wildcards === true) {
            $terms->transform(function ($term) {
                return $term.'*';
            });
        }

        return $terms;
    }
}

<?php

namespace Swis\Laravel\Fulltext;

use Illuminate\Support\Facades\Config;

class TermBuilder
{
    public static function terms($search)
    {
        $wildcards = Config::get('laravel-fulltext.enable_wildcards');

        // Remove every boolean operator (+, -, > <, ( ), ~, *, ", @distance) from the search query
        // else we will break the MySQL query.
        $search = trim(preg_replace('/[+\-><\(\)~*\"@]+/', ' ', $search));

        $terms = collect(preg_split('/[\s,]+/', $search));

        if ($wildcards === true) {
            $terms->transform(function ($term) {
                return $term.'*';
            });
        }

        return $terms;
    }
}

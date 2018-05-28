<?php
namespace Swis\LaravelFulltext;

class TermBuilder {

    public static function terms($search){
        $wildcards = config('laravel-fulltext.enable_wildcards');

        $terms = collect(preg_split('/[\s,]+/', $search));

        if($wildcards === true){
            $terms->transform(function($term){
                return $term. '*';
            });
        }

        return $terms;
    }

}

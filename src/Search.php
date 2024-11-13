<?php

namespace Swis\Laravel\Fulltext;

use Illuminate\Support\Facades\Config;

class Search implements SearchInterface
{
    /**
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Collection|\Swis\Laravel\Fulltext\IndexedRecord[]
     */
    public function run($search)
    {
        $query = $this->searchQuery($search);

        return $query->get();
    }

    /**
     * @param  string  $search
     * @param  string  $class
     * @return \Illuminate\Database\Eloquent\Collection|\Swis\Laravel\Fulltext\IndexedRecord[]
     */
    public function runForClass($search, $class)
    {
        $query = $this->searchQuery($search);
        $query->where('indexable_type', (new $class)->getMorphClass());

        return $query->get();
    }

    /**
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function searchQuery($search)
    {
        $termsBool = '';
        $termsMatch = '';

        if ($search) {
            $terms = TermBuilder::terms($search);

            $termsBool = '+'.$terms->implode(' +');
            $termsMatch = ''.$terms->implode(' ');
        }

        $titleWeight = str_replace(',', '.', (float) Config::get('laravel-fulltext.weight.title', 1.5));
        $contentWeight = str_replace(',', '.', (float) Config::get('laravel-fulltext.weight.content', 1.0));

        $query = IndexedRecord::query()
            ->whereRaw('MATCH (indexed_title, indexed_content) AGAINST (? IN BOOLEAN MODE)', [$termsBool])
            ->orderByRaw(
                '('.$titleWeight.' * (MATCH (indexed_title) AGAINST (?)) +
              '.$contentWeight.' * (MATCH (indexed_title, indexed_content) AGAINST (?))
             ) DESC',
                [$termsMatch, $termsMatch])
            ->limit(Config::get('laravel-fulltext.limit-results'));

        if (Config::get('laravel-fulltext.exclude_feature_enabled')) {
            $query->with(['indexable' => function ($query) {
                $query->where(Config::get('laravel-fulltext.exclude_records_column_name'), '=', true);
            }]);
        } else {
            $query->with('indexable');
        }

        return $query;
    }
}

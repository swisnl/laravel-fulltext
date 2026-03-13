<?php

namespace Swis\Laravel\Fulltext;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class Search implements SearchInterface
{
    /**
     * @param  string  $search
     * @return Collection|IndexedRecord[]
     */
    public function run($search)
    {
        $query = $this->searchQuery($search);

        return $query->get();
    }

    /**
     * @param  string  $search
     * @param  string  $class
     * @return Collection|IndexedRecord[]
     */
    public function runForClass($search, $class)
    {
        $query = $this->searchQuery($search);
        $query->where('indexable_type', (new $class)->getMorphClass());

        return $query->get();
    }

    /**
     * @param  string  $search
     * @return Builder
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

        $titleWeight = str_replace(',', '.', (float) config('laravel-fulltext.weight.title', 1.5));
        $contentWeight = str_replace(',', '.', (float) config('laravel-fulltext.weight.content', 1.0));

        $query = IndexedRecord::query()
            ->whereRaw('MATCH (indexed_title, indexed_content) AGAINST (? IN BOOLEAN MODE)', [$termsBool])
            ->orderByRaw(
                '('.$titleWeight.' * (MATCH (indexed_title) AGAINST (?)) +
              '.$contentWeight.' * (MATCH (indexed_title, indexed_content) AGAINST (?))
             ) DESC',
                [$termsMatch, $termsMatch])
            ->limit(config('laravel-fulltext.limit-results'));

        if (config('laravel-fulltext.exclude_feature_enabled')) {
            $query->with(['indexable' => function ($query) {
                $query->where(config('laravel-fulltext.exclude_records_column_name'), '=', true);
            }]);
        } else {
            $query->with('indexable');
        }

        return $query;
    }
}

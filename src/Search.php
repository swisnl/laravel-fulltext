<?php

namespace Swis\Laravel\Fulltext;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Search implements SearchInterface
{
    /**
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Collection<Model>
     */
    public function run($search)
    {
        $query = $this->searchQuery($search);

        return $query->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<Model>
     */
    public function runForClass(string $search, string $class)
    {
        $query = $this->searchQuery($search);
        $query->where('indexable_type', (new $class)->getMorphClass());

        return $query->get();
    }

    public function searchQuery(string $search): Builder
    {
        $termsBool = '';
        $termsMatch = '';

        if ($search) {
            $terms = TermBuilder::terms($search);

            $termsBool = '+'.$terms->implode(' +');
            $termsMatch = ''.$terms->implode(' ');
        }

        $titleWeight = str_replace(',', '.', sprintf('%f', Config::get('laravel-fulltext.weight.title', 1.5)));
        $contentWeight = str_replace(',', '.', sprintf('%f', Config::get('laravel-fulltext.weight.content', 1.0)));

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

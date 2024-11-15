<?php

namespace Swis\Laravel\Fulltext;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class Search implements SearchInterface
{
    public function run(string $search): Collection
    {
        $query = $this->searchQuery($search);

        return $query->get();
    }

    public function runForClass(string $search, string $class): Collection
    {
        if (! is_subclass_of($class, Model::class)) {
            return new Collection;
        }

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
            $termsMatch = $terms->implode(' ');
        }

        $titleWeight = str_replace(',', '.', sprintf('%f', Config::float('laravel-fulltext.weight.title', 1.5)));
        $contentWeight = str_replace(',', '.', sprintf('%f', Config::float('laravel-fulltext.weight.content', 1.0)));

        $query = IndexedRecord::query()
            ->whereRaw('MATCH (indexed_title, indexed_content) AGAINST (? IN BOOLEAN MODE)', [$termsBool])
            ->orderByRaw(
                '('.$titleWeight.' * (MATCH (indexed_title) AGAINST (?)) +
              '.$contentWeight.' * (MATCH (indexed_title, indexed_content) AGAINST (?))
             ) DESC',
                [$termsMatch, $termsMatch])
            ->limit(Config::integer('laravel-fulltext.limit-results'));

        if (Config::boolean('laravel-fulltext.exclude_feature_enabled')) {
            $query->with(['indexable' => function ($query) {
                $query->where(Config::get('laravel-fulltext.exclude_records_column_name'), '=', true);
            }]);
        } else {
            $query->with('indexable');
        }

        return $query;
    }
}

<?php

namespace Swis\LaravelFulltext;

class Search implements SearchInterface
{
    /**
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Collection|\Swis\LaravelFulltext\IndexedRecord[]
     */
    public function run($search)
    {
        $query = $this->searchQuery($search);
        return $query->get();
    }

    /**
     * @param $search
     * @param $class
     * @return \Illuminate\Database\Eloquent\Collection|\Swis\LaravelFulltext\IndexedRecord[]
     */
    public function runForClass($search, $class)
    {
        $query = $this->searchQuery($search);
        $query->where('indexable_type', $class);
        return $query->get();
    }

    /**
     * @param string $search
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

        $titleWeight = str_replace(',', '.', (float)config('laravel-fulltext.weight.title', 1.5));
        $contentWeight = str_replace(',', '.', (float)config('laravel-fulltext.weight.content', 1.0));

        $query = IndexedRecord::query()
          ->whereRaw('MATCH (indexed_title, indexed_content) AGAINST (? IN BOOLEAN MODE)', [$termsBool])
          ->orderByRaw(
              '(' .$titleWeight. ' * (MATCH (indexed_title) AGAINST (?)) +
              ' . $contentWeight. ' * (MATCH (indexed_title, indexed_content) AGAINST (?))
             ) DESC',
              [$termsMatch, $termsMatch]
          )
          ->limit(config('laravel-fulltext.limit-results'))
          ->with('indexable');
        return $query;
    }
}

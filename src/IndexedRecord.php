<?php

namespace Swis\Laravel\Fulltext;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Config;
use Swis\Laravel\Fulltext\Contracts\Indexable;

/**
 * @property Indexable $indexable
 */
class IndexedRecord extends Model
{
    protected $table = 'laravel_fulltext';

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = Config::get('laravel-fulltext.db_connection');

        if (!is_string($connection)) {
            $connection = null;
        }

        $this->connection = $connection;

        parent::__construct($attributes);
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function indexable(): MorphTo
    {
        return $this->morphTo();
    }

    public function updateIndex(): void
    {
        $this->setAttribute('indexed_title', $this->indexable->getIndexTitle());
        $this->setAttribute('indexed_content', $this->indexable->getIndexContent());
        $this->save();
    }
}

<?php

namespace Swis\Laravel\Fulltext;

use Swis\Laravel\Fulltext\Contracts\Indexable;

class ModelObserver
{
    /**
     * The class names that syncing is disabled for.
     *
     * @var array<string, bool>
     */
    protected static array $syncingDisabledFor = [];

    /**
     * Enable syncing for the given class.
     */
    public static function enableSyncingFor(string $class): void
    {
        unset(static::$syncingDisabledFor[$class]);
    }

    /**
     * Disable syncing for the given class.
     */
    public static function disableSyncingFor(string $class): void
    {
        static::$syncingDisabledFor[$class] = true;
    }

    /**
     * Determine if syncing is disabled for the given class or model.
     */
    public static function syncingDisabledFor(string|object $class): bool
    {
        $class = is_object($class) ? get_class($class) : $class;

        return isset(static::$syncingDisabledFor[$class]);
    }

    /**
     * Handle the created event for the model.
     */
    public function created(Indexable $model): void
    {
        if (static::syncingDisabledFor($model)) {
            return;
        }

        $model->indexRecord();
    }

    /**
     * Handle the updated event for the model.
     */
    public function updated(Indexable $model): void
    {
        $this->created($model);
    }

    /**
     * Handle the deleted event for the model.
     */
    public function deleted(Indexable $model): void
    {
        if (static::syncingDisabledFor($model)) {
            return;
        }

        $model->unIndexRecord();
    }

    /**
     * Handle the restored event for the model.
     */
    public function restored(Indexable $model): void
    {
        $this->created($model);
    }
}

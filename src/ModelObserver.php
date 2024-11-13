<?php

namespace Swis\Laravel\Fulltext;

class ModelObserver
{
    /**
     * The class names that syncing is disabled for.
     *
     * @var array
     */
    protected static $syncingDisabledFor = [];

    /**
     * Enable syncing for the given class.
     *
     * @param  string  $class
     */
    public static function enableSyncingFor($class)
    {
        unset(static::$syncingDisabledFor[$class]);
    }

    /**
     * Disable syncing for the given class.
     *
     * @param  string  $class
     */
    public static function disableSyncingFor($class)
    {
        static::$syncingDisabledFor[$class] = true;
    }

    /**
     * Determine if syncing is disabled for the given class or model.
     *
     * @param  object|string  $class
     * @return bool
     */
    public static function syncingDisabledFor($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return isset(static::$syncingDisabledFor[$class]);
    }

    /**
     * Handle the created event for the model.
     *
     * @param  \Swis\Laravel\Fulltext\Contracts\Indexable  $model
     */
    public function created($model)
    {
        if (static::syncingDisabledFor($model)) {
            return;
        }

        $model->indexRecord();
    }

    /**
     * Handle the updated event for the model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function updated($model)
    {
        $this->created($model);
    }

    /**
     * Handle the deleted event for the model.
     *
     * @param  \Swis\Laravel\Fulltext\Contracts\Indexable  $model
     */
    public function deleted($model)
    {
        if (static::syncingDisabledFor($model)) {
            return;
        }

        $model->unIndexRecord();
    }

    /**
     * Handle the restored event for the model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function restored($model)
    {
        $this->created($model);
    }
}

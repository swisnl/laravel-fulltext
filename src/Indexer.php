<?php
namespace Swis\LaravelFulltext;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Swis\LaravelFulltext\Indexable;

class Indexer {

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function indexModel(Model $model){
        $model->indexRecord();
    }


    public function indexOneByClass($class, $id) {
        $model = ($class)::find($id);
        if(in_array(Indexable::class, class_uses($model), true)){
            $this->indexModel($model);
        }
    }

    public function indexAllByClass($class)
    {
        /**
         * @var Country
         */
        $model = new $class;
        $self = $this;
        if(in_array(Indexable::class, class_uses($model), true)){
            $model->all()->each(function($modelRecord) use ($self) {
                $self->indexModel($modelRecord);
            });
        }
    }

}

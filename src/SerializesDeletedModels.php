<?php
namespace Nazieb\Queue;

use Illuminate\Contracts\Database\ModelIdentifier;
use Illuminate\Queue\SerializesModels;

trait SerializesDeletedModels
{
    use SerializesModels;

    /**
     * @inheritdoc
     */
    protected function getRestoredPropertyValue($value)
    {
        if ($value instanceof ModelIdentifier) {
            $model = new $value->class;

            if (method_exists($model, 'withTrashed')) {
                $model = $model->withTrashed();
            }

            return $model->findOrFail($value->id);
        }

        return $value;
    }
}
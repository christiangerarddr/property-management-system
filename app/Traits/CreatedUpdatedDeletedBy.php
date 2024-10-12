<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait CreatedUpdatedDeletedBy
{
    public static function bootCreatedUpdatedDeletedBy()
    {
        static::creating(function (Model $model) {
            if (! $model->isDirty('created_by')) {
                $model->created_by = auth()->id();
            }
            if (! $model->isDirty('updated_by')) {
                $model->updated_by = auth()->id();
            }
        });

        static::updating(function (Model $model) {
            if (! $model->isDirty('updated_by')) {
                $model->updated_by = auth()->id();
            }
        });

        static::deleting(function (Model $model) {
            if (! $model->isDirty('deleted_by')) {
                $model->deleted_by = auth()->id();
                $model->saveQuietly();
            }
        });
    }
}

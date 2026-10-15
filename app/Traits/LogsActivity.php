<?php

namespace App\Traits;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {

            activity_log(
                'Menambahkan data ' . class_basename($model),
                $model->getTable(),
                $model->getKey()
            );

        });

        static::updated(function ($model) {

            activity_log(
                'Mengubah data ' . class_basename($model),
                $model->getTable(),
                $model->getKey()
            );

        });

        static::deleted(function ($model) {

            activity_log(
                'Menghapus data ' . class_basename($model),
                $model->getTable(),
                $model->getKey()
            );

        });
    }
}
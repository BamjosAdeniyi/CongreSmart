<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasTracking
{
    protected static function bootHasTracking()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $createdByField = $model->getCreatedByField();
                if ($createdByField && !$model->$createdByField) {
                    $model->$createdByField = Auth::id();
                }

                $updatedByField = $model->getUpdatedByField();
                if ($updatedByField && !$model->$updatedByField) {
                    $model->$updatedByField = Auth::id();
                }
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $updatedByField = $model->getUpdatedByField();
                if ($updatedByField) {
                    $model->$updatedByField = Auth::id();
                }
            }
        });
    }

    public function getCreatedByField()
    {
        if (isset($this->createdByField)) {
            return $this->createdByField;
        }

        // Default fields based on table structure
        $fields = ['created_by', 'marked_by', 'recorded_by'];
        foreach ($fields as $field) {
            if (\Illuminate\Support\Facades\Schema::hasColumn($this->getTable(), $field)) {
                return $field;
            }
        }

        return null;
    }

    public function getUpdatedByField()
    {
        return isset($this->updatedByField) ? $this->updatedByField : 'updated_by';
    }
}

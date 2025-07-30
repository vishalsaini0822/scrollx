<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBlockSettings extends Model
{
    protected $fillable = [
        'user_id',
        'project_name',
        'settings_data',
        'last_modified'
    ];

    protected $casts = [
        'settings_data' => 'array',
        'last_modified' => 'datetime'
    ];

    /**
     * Get the user that owns the block settings.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Update last_modified timestamp on save
        static::saving(function ($model) {
            $model->last_modified = now();
        });
    }
}

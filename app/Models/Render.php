<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Render extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'resolution',
        'format',
        'frame_rate',
        'speed',
        'running_time',
        'status',
        'file_path',
        'file_size',
        'email_notification',
        'started_at',
        'completed_at',
        'error_message'
    ];

    protected $casts = [
        'email_notification' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the project that owns the render.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user that owns the render.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'template_name',
        'end_credits_type',
        'resolution',
        'user_id',
        'status',
        'google_sheet_url',
        'google_sheet_id',
    ];

    /**
     * Get the user that owns the project.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

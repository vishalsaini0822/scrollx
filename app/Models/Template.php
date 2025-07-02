<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use SoftDeletes;

    protected $table = 'templates';
    protected $fillable = [
        'template_name',
        'image',
        'sheet_url',
        'spreadsheetId'
    ];

    protected $dates = ['deleted_at'];
}

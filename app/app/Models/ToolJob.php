<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolJob extends Model
{
    protected $table = 'tool_jobs';

    protected $fillable = [
        'slug',
        'status',
        'progress',
        'input_paths',
        'result_path',
        'error_message',
    ];

    protected $casts = [
        'input_paths' => 'array',
        'progress' => 'integer',
    ];
}

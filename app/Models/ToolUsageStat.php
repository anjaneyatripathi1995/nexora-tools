<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ToolUsageStat extends Model
{
    protected $fillable = ['tool_id', 'date', 'count'];

    protected $casts = ['date' => 'date'];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public static function record(int $toolId): void
    {
        $today = now()->toDateString();
        $row = static::query()->firstOrCreate(
            ['tool_id' => $toolId, 'date' => $today],
            ['count' => 0]
        );
        $row->increment('count');
    }
}

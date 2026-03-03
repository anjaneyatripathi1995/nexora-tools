<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedItem extends Model
{
    protected $fillable = ['user_id', 'item_type', 'item_slug'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

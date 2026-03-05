<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'icon', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function tools(): BelongsToMany
    {
        return $this->belongsToMany(Tool::class, 'tool_category')->withPivot('sort_order')->orderBy('tool_category.sort_order');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'category_id',
        'description',
        'icon',
        'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function categoryRelation(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'tool_category')->withPivot('sort_order');
    }

    public function usageStats(): HasMany
    {
        return $this->hasMany(ToolUsageStat::class);
    }
}
<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'access_rules',
        'is_master',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'access_rules' => 'array',
            'is_master' => 'boolean',
        ];
    }

    public function isMasterAdmin(): bool
    {
        return $this->role === 'admin' && $this->is_master;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /** Whether this admin can manage the given section (tools, projects, apps, templates). Null access_rules = full access. */
    public function canManage(string $section): bool
    {
        if ($this->role !== 'admin') {
            return false;
        }
        if ($this->access_rules === null || $this->access_rules === []) {
            return true;
        }
        return in_array($section, (array) $this->access_rules, true);
    }

    public function savedItems()
    {
        return $this->hasMany(SavedItem::class);
    }

    public function toolHistory()
    {
        return $this->hasMany(ToolHistory::class);
    }
}

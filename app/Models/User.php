<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_activity_at' => 'datetime',
    ];

    // hasMany messageas
    public function messages() : HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function getActiveUserAfterTimestamp($timestamp) : Collection
    {
        return $this->where('last_activity_at', '>', $timestamp)->orderBy('name')->get();
    }
}

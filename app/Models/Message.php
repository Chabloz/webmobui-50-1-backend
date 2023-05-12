<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'msg',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
    ];

    protected $casts = [
        'sentByMe' => 'boolean',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAllAfterTimestamp($timestamp) : Collection
    {
        return $this->where('created_at', '>', $timestamp)->with('user:id,name')->get()->append('sentByMe');
    }

    protected function getSentByMeAttribute(): bool
    {
        $user = Auth::user();
        if (!$user) return false;
        return $this->user->id === $user->id;
    }

}

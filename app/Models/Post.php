<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
        "verified_at",
        'verified_by',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // Mark post as verified
    public function verify()
    {
        $this->update([
            'verified_at' => now(),
             'verified_by' => auth()->id(),
        ]);
    }

    // Remove verification
    public function unverify()
    {
        $this->update([
            'verified_at' => null,
            'verified_by' => null,
        ]);
    }

    // Check if verified
    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    // Scope for verified posts
    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }

    // Scope for unverified posts
    public function scopeUnverified($query)
    {
        return $query->whereNull('verified_at');
    }
    public function verifier()
{
    return $this->belongsTo(User::class, 'verified_by');
}
}
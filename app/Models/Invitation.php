<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = ["email", "token", "expires_at", "used_at"];

    protected $casts = [
        "expires_at" => "datetime",
        "used_at" => "datetime",
    ];

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isUsed()
    {
        return !is_null($this->used_at);
    }
}

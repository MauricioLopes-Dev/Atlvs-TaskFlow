<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'owner_id', 'image_path', 'image_disk'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

     public function getResolvedImageDiskAttribute(): string
    {
        return $this->image_disk ?: config('taskflow.project_images_disk', 'public');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        return Storage::disk($this->resolved_image_disk)->url($this->image_path);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

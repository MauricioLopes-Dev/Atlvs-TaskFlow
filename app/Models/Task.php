<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'project_id',
        'assigned_to',
        'due_date',
        'figma_link',
        'repo_link',
        'staging_link'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class)->latest();
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class)->latest();
    }
}

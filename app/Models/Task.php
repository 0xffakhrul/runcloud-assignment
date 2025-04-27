<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'deadline', 'is_completed', 'workspace_id'
    ];

    public function workspace():BelongsTo {
        return $this->belongsTo(Workspace::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class KanbanTask extends Model
{
    protected $fillable = [
        'kanban_column_id',
        'user_id',
        'title',
        'description',
        'priority',
        'position'
    ];

    public function column(): BelongsTo
    {
        return $this->belongsTo(KanbanColumn::class, 'kanban_column_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
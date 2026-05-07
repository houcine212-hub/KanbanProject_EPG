<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\KanbanTask;

class KanbanColumn extends Model
{
    protected $fillable = ['name', 'color', 'position'];

    public function tasks(): HasMany
    {
        return $this->hasMany(KanbanTask::class)->orderBy('position');
    }
}
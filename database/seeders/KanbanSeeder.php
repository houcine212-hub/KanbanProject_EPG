<?php

namespace Database\Seeders;

use App\Models\KanbanColumn;
use Illuminate\Database\Seeder;

class KanbanSeeder extends Seeder
{
    public function run(): void
    {
        $columns = [
            ['name' => 'To Do', 'color' => '#64748b', 'position' => 0],
            ['name' => 'In Progress', 'color' => '#6366f1', 'position' => 1],
            ['name' => 'Review', 'color' => '#f59e0b', 'position' => 2],
            ['name' => 'Done', 'color' => '#10b981', 'position' => 3],
        ];

        foreach ($columns as $column) {
            KanbanColumn::create($column);
        }
    }
}
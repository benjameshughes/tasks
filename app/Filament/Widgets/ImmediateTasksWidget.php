<?php

namespace App\Filament\Widgets;

use App\Enums\Priority;
use App\Enums\Status;
use App\Models\Task;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class ImmediateTasksWidget extends BaseWidget
{
    protected int | string | array $columnSpan = [
        'sm' => 1,
        'md' => 2,
        'lg' => 3,
        'xl' => 4,
    ];
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Task::query()
                    ->leftJoin('task_user', 'tasks.id', '=', 'task_user.task_id')
                    ->where('task_user.user_id', Auth::id())
                    ->where('tasks.priority', Priority::immediate)
                    ->orderBy('tasks.id', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
            ]);
    }
}

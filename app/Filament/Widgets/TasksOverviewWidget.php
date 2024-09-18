<?php

namespace App\Filament\Widgets;

use App\Enums\Priority;
use App\Enums\Status;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class TasksOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('To Do', Task::whereNot("status", Status::complete)->where("user_id", Auth::id())->count()),
            Stat::make('Completed, Gz', Task::where("status", Status::complete)->where("user_id", Auth::id())->count()),
            Stat::make('Probably should look at these', Task::where("priority", Priority::high)->whereNot('status', Status::complete)->where("user_id", Auth::id())->count()),
        ];
    }
}

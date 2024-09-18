<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Actions\CompleteTaskAction;
use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTask extends ViewRecord
{
    protected static string $resource = TaskResource::class;

    protected function title(Task $record): string
    {
     return $record->name();
    }

    protected function getHeaderActions(): array
    {
        return [
            CompleteTaskAction::make("Complete"),
            Actions\EditAction::make('Edit Task')->iconButton()->icon('heroicon-o-pencil'),
            Actions\DeleteAction::make('Delete')->iconButton()->icon('heroicon-o-trash'),
        ];
    }
}

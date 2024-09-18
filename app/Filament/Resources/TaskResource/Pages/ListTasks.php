<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Exports\TaskExporter;
use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\ExportAction;
use Illuminate\Support\Facades\Auth;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected static ?string $title = 'Do I Have To Do These?';

    public static function getNavigationBadge(): ?string
    {
        return auth()->user()->tasks()->count();
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make('export')->exporter(TaskExporter::class)

        ];
    }
}

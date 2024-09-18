<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Resources\Pages\Page;

class TaskImportExport extends Page
{
    protected static string $resource = TaskResource::class;

    protected static ?string $slug = 'import-export';

    protected static string $view = 'filament.resources.task-resource.pages.task-import-export';
}

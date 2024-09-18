<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;

    // Remove create another button
    protected static bool $canCreateAnother = false;

    // Redirect back to task list after creating
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

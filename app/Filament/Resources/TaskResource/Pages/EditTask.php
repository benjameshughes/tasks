<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Enums\Status;
use App\Filament\Actions\CompleteTaskAction;
use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Livewire\Livewire;
use Mockery\Matcher\Not;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected static ?string $title = 'Edit Task';

    // Redirect back to task list after creating
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Updated!')
            ->body('The task has been updated!')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

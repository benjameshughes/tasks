<?php

namespace App\Filament\Actions;

use App\Enums\Status;
use App\Models\Task;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithRecord;
use Illuminate\Database\Eloquent\Model;

class CompleteTaskAction extends Action
{
    use InteractsWithRecord;
    public static function getDefaultName(): ?string
    {
        return parent::getDefaultName();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->hidden(function(Model $record): bool {
            if (!$record instanceof Model) {
                return true;
            }
            return false;
        });

        $this->label('Complete');
        $this->icon('heroicon-m-check-circle');
        $this->iconButton();
        $this->color('success');
        $this->requiresConfirmation();
        $this->modalHeading('Mark task as complete?');
        $this->modalDescription('Do you want to complete the task?');
        $this->action(function (){
            $record = $this->getRecord();
            if($record instanceof Task) {
                $record->status(Status::complete);
            }
        });
    }
}

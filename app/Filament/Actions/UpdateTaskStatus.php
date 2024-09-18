<?php

namespace App\Filament\Actions;

use App\Enums\Priority;
use App\Enums\Status;
use App\Models\Task;
use App\Notifications\TaskUpdated;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class UpdateTaskStatus extends Action
{
    protected ?\Closure $mutateRecordDataUsing = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Update Task');
        $this->icon('heroicon-s-pencil-square');
        $this->iconButton();
        $this->color('warning');
        $this->modalHeading('Update Task');
        $this->modalWidth('md');

        $this->fillForm(function (Model $record, Table $table): array {
            if ($translatableContentDriver = $table->makeTranslatableContentDriver()) {
                $data = $translatableContentDriver->getRecordAttributesToArray($record);
            } else {
                $data = $record->attributesToArray();
            }

            if ($this->mutateRecordDataUsing) {
                $data = $this->evaluate($this->mutateRecordDataUsing, ['data' => $data]);
            }

            return $data;
        });

        $this->form([
            Select::make('status')
                ->options(Status::class)
                ->required()
                ->rule(new Enum(Status::class)),
            Select::make('priority')
                ->options(Priority::class)
                ->required()
                ->rule(new Enum(Priority::class)),
            DateTimePicker::make('due_date'),
        ]);

        $this->action(function (Task $record, array $data): void {
            try {
                $record->update([
                    'status' => $data['status'],
                    'priority' => $data['priority'],
                    'due_date' => $data['due_date'],
                ]);

                // Send database notification
                Auth::user()->notify(new TaskUpdated($record));

                // Queue task with due date to send a reminder


                // Send toast notification
                Notification::make()
                    ->title('Task Updated')
                    ->success()
                    ->body('Task details have been updated')
                    ->send();

                $this->success();
            } catch (\Exception $e) {
                // Send toast notification for failure
                Notification::make()
                    ->title('Update Failed')
                    ->danger()
                    ->body("An error occurred while updating the task: {$e->getMessage()}")
                    ->send();

                $this->failure();
            }
        });

        $this->visible(function (Task $record): bool
        {
            // Check is user is the owner of the task
            if (!Auth::check() || Auth::user()->id !== $record->user_id) {
                return false;
            }

            $user = Auth::user();

            return $user->can('update', $record);
        });
    }
}

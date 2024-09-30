<?php

namespace App\Filament\Actions;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class AssignUserBulkAction extends BulkAction
{


    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Assign User');
        $this->icon('heroicon-s-user-group');
        $this->color('success');
        $this->modalHeading('Assign User to Selected Tasks');
        $this->modalWidth('md');

        $this->form([
            Select::make('user_id')
                ->label('User')
                ->options(User::query()->pluck('name', 'id'))
                ->required(),
        ]);

        $this->action(function (Collection $records, array $data): void {
            $user = User::find($data['user_id']);

            $records->each(function ($task) use ($user) {
                $task->user()->sync([$user->id]);
            });

            $this->success();
        });
    }
}
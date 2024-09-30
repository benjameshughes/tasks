<?php

namespace App\Filament\Actions;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;

class AssignUserAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Assign User');
        $this->icon('heroicon-s-user-group');
        $this->color('success');
        $this->modalHeading('Assign User');
        $this->modalWidth('md');

        $this->form([
            Select::make('user_id')
                ->label('User')
                ->options(User::query()->pluck('name', 'id'))
                ->required(),
        ]);

        $this->action(function ($record, array $data): void {
            $user = User::find($data['user_id']);
            $record->user()->sync([$user->id]);
            $this->success();
        });
    }
}
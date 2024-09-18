<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Resources\Pages\ListRecords;

class TaskComplete extends ListRecords
{
    protected static string $resource = TaskResource::class;
    protected static ?string $navigationLabel = 'Complete';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Tasks';
    protected static ?string $navigationBadgeTooltip = 'View completed tasks';


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->defaultSort('name', 'asc');
    }
}

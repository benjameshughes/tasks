<?php

namespace App\Filament\Resources;

use App\Enums\Priority;
use App\Enums\Status;
use App\Filament\Actions\AssignUserBulkAction;
use App\Filament\Actions\AssignUserAction;
use App\Filament\Actions\UpdateTaskStatus;
use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use TangoDevIt\FilamentEmojiPicker\EmojiPickerAction;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationLabel = 'Task List';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Tasks';

    protected static ?string $navigationBadgeTooltip = 'Task List';

    /**
     * Modify the query of the table to not show the completed tasks.
     * Do I like this? How will a user see their complete tasks? Custom page?
     * @return Builder
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereNot('status', status::complete);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                        ->suffixAction(EmojiPickerAction::make('emoji-title')),
                        Forms\Components\RichEditor::make('description')
                            ->columnSpanFull(),
                    ]),
                    Forms\Components\Section::make([
                        Forms\Components\DateTimePicker::make('due_date'),
                        Forms\Components\Radio::make('priority')
                            ->options(Priority::class),
                        Forms\Components\Radio::make('status')
                            ->options(Status::class),
                        Forms\Components\CheckboxList::make('category')
                            ->required()
                            ->relationship('category', 'name'),
//                            ->createOptionForm([
//                                Forms\Components\TextInput::make('name'),
//                            ])
//                            ->createOptionUsing(function (array $data): int {
//                                return auth()->user()->categories()->create($data)->getKey();
//                            })
//                            ->editOptionForm([
//                                Forms\Components\TextInput::make('name')->suffixAction(EmojiPickerAction::make('emoji-title')),
//                            ])
                        Forms\Components\FileUpload::make('attachments')
                            ->multiple()
                            ->visibility('private')
                            ->disk('local')
                            ->directory('public')
                    ])->grow(false),
                ])->from('md')->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label("Details")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('priority')
                    ->toggleable()
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->sortable()
                    ->badge(),
            ])
            ->groups([
                Group::make('status')->collapsible()->getLabel(),
                Group::make('priority')->collapsible()->getLabel()])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options(Status::class)
                    ->multiple(),
                Tables\Filters\SelectFilter::make('priority')
                    ->options(Priority::class)
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton()->modal(),
                UpdateTaskStatus::make('Status'),
                AssignUserAction::make('Assign User'),
//                CompleteTaskAction::make(),
            ])
            ->bulkActions([
                 Tables\Actions\DeleteBulkAction::make(),
                AssignUserBulkAction::make('Assign User'),
            ])
            ->reorderable()
            ->extremePaginationLinks();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
            'view' => Pages\ViewTask::route('/{record}'),
            'import-export' => Pages\TaskImportExport::route('/import-export'),
            'complete' => Pages\TaskComplete::route('/complete'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficeResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OfficeResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';


    public static function getLabel(): string
    {
        return __('Office Account');
    }

    public static function getPluralLabel(): string
    {
        return __('Office Account');
    }


    public static function getNavigationSort(): ?int
    {
        return 2 ;
    }

    // Only show users where 'type' is 'office'
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes()->where('type', 'office');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('photo')
                    ->columnSpan(2)
                    ->label(__('Image'))
                    ->directory('OfficeImages') ,
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('Name')),

                Forms\Components\TextInput::make('whats_number')
                    ->maxLength(255)
                    ->label(__('WhatsApp')),

                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(255)
                    ->label(__('Phone')),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255)
                    ->label(__('Location')),
                Forms\Components\Textarea::make('description')
                ->label(__('Description'))
                ->required()
                ->columnSpan(2),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn ($record) => $record === null) // Required only on create
                    ->maxLength(255)
                    ->label(__('Password')),

                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->required(fn ($record) => $record === null) // Required only on create
                    ->same('password')
                    ->maxLength(255)
                    ->label(__('Confirm Password')),

                Forms\Components\Hidden::make('type')->default('office')
            ])
            ->columns(2); // Layout for the form with 2 columns
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Full Name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('number')
                    ->label(__('Phone Number'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->label(__('Location')),

                Tables\Columns\ToggleColumn::make('block')
                    ->label(__('Blocked'))
                    ->toggleable()
            ])
            ->actions([
                // Custom action to toggle block status
                Tables\Actions\Action::make('toggleBlock')
                    ->label(__('Toggle Block'))
                    ->action(function (User $record) {
                        $record->block = !$record->block;
                        $record->save();
                    })
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger'),

                // Delete action
                Tables\Actions\DeleteAction::make()->label(__('Delete Account')),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label(__('Delete Account')),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOffices::route('/'),
            'create' => Pages\CreateOffice::route('/create'),
            'edit' => Pages\EditOffice::route('/{record}/edit'),
        ];
    }


}

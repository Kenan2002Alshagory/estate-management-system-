<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\DeleteAction;
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';


    public static function getLabel(): string
    {
        return __('User Account');
    }

    public static function getPluralLabel(): string
    {
        return __('User Account');
    }
    public static function getNavigationSort(): ?int
    {
            return 1 ;
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes()->where('type', 'client');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label(__('Number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('block')
                    ->label(__('Blocked'))

            ])
            ->filters([
                //
            ])
            ->actions([
                // Action for toggling the block status
                Tables\Actions\Action::make('toggleBlock')
                    ->label(__('Toggle Block'))
                    ->action(function (User $record) {
                        // Toggle the block status
                        $record->block = !$record->block;
                        $record->save();
                    })
                    ->icon('heroicon-o-no-symbol') // Icon for the action (optional)
                    ->color('primary'), // You can use a different color if needed

                // Delete action
                DeleteAction::make()->label(__('Delete Account')),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label(__('Delete Account'))
                ,
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false ;// TODO: Change the autogenerated stub
    }
    public static function canEdit(Model $record): bool
    {
        return false ;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
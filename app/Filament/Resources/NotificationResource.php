<?php
namespace App\Filament\Resources;

use App\Filament\Resources\NotificationResource\Pages;


use App\Models\PublicNotification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NotificationResource extends Resource
{
    protected static ?string $model = PublicNotification::class;
    protected static ?string $navigationIcon = 'heroicon-o-bell';

    public static function getLabel(): string
    {
        return __('Notifications');
    }

    public static function getPluralLabel(): string
    {
        return __('Notifications');
    }


    public static function getNavigationSort(): ?int
    {
        return 4 ;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('body')
                    ->label(__('Body'))
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label(__('Type'))
                    ->options([
                        'office' => __('Office') ,
                        'client' => __('Client')
                    ]) ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')                    ->label(__('Title'))
                ,
                Tables\Columns\TextColumn::make('body')                    ->label(__('Body'))
                ,
                Tables\Columns\TextColumn::make('type')                    ->label(__('Type'))
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'office' => __('Office'),
                            'client' => __('Client'),
                            default => $state,
                        };
                    })
                ,
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))

            ->dateTime(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotifications::route('/'),
            'create' => Pages\CreateNotification::route('/create'),
            'edit' => Pages\EditNotification::route('/{record}/edit'),
        ];
    }
}

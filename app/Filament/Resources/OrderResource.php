<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages\CreateOrder;
use App\Filament\Resources\OrderResource\Pages\EditOrder;
use App\Filament\Resources\OrderResource\Pages\ListOrders;
use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-chevron-double-up';
    public static function getLabel(): string
    {
        return __('Orders');
    }

    public static function getPluralLabel(): string
    {
        return __('Orders');
    }
    public static function getNavigationSort(): ?int
    {
        return 3 ;
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.number')
                    ->label(__('Number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.location')
                    ->label(__('Location'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\Action::make('accept')
                    ->label(__('Accept'))
                    ->color('success')
                    ->action(function (Order $record) {
                        $user = $record->user;
                        $user->type = 'office';
                        $user->verifyOffice = true;
                        $user->save();

                        // Delete the order after accepting
                        $record->delete();
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-check-circle'),

                Tables\Actions\Action::make('reject')
                    ->label(__('Reject'))
                    ->color('danger')
                    ->action(function (Order $record) {
                        $user = $record->user;
                        $user->type = 'client';
                        $user->save();

                        // Delete the order after rejecting
                        $record->delete();
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-x-circle'),
            ])
            ->filters([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function canEdit(Model $record): bool
    {
        return false ;
    }

    public static function canCreate(): bool
    {
            return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}

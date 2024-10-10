<?php
namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;

class NewestUsersWidget extends BaseWidget
{
    protected function getTableHeading(): string
    {
        return __('Newest Users'); // Translated table name
    }
    protected function getTableQuery(): Builder
    {
        return User::query()->latest()->limit(5); // Adjust the limit if needed
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->label(__('User ID')),
            TextColumn::make('name')->label(__('Name')),
          //  TextColumn::make('email')->label(__('Email')),
            TextColumn::make('created_at')->label(__('Registration Date'))->date(),
        ];
    }
}

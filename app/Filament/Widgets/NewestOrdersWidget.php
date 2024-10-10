<?php
namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class NewestOrdersWidget extends BaseWidget
{

    protected function getTableHeading(): string
    {
        return __('Newest Orders'); // Translated table name
    }

    protected function getTableQuery(): Builder
    {
        return Order::query()->latest()->limit(5); // Adjust the limit if needed
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->label(__('Order ID')),
            TextColumn::make('user.name')->label(__('User')),
            TextColumn::make('created_at')->label(__('Order Date'))->date(),

        ];
    }
}

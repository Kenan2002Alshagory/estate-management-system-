<?php
namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatisticsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total_user = User::withoutGlobalScopes()->where('type', 'client')->count();
        $total_office = User::withoutGlobalScopes()->where('type', 'office')->count();
        $total_order = Order::withoutGlobalScopes()->count();

        return [
            // Total Users Stat
            Stat::make(__('Total Users'), $total_user)
                ->color('bg-[#2A8478]') // Custom color
                ->icon('heroicon-o-user') // Suitable icon
            ,

            // Total Offices Stat
            Stat::make(__('Total Offices'), $total_office)
                ->color('bg-[#2A8478]') // Custom color
                ->icon('heroicon-o-building-office-2') // Corrected icon
            ,

            // Total Orders Stat
            Stat::make(__('Total Orders'), $total_order)
                ->color('bg-[#2A8478]') // Custom color
                ->icon('heroicon-o-chevron-double-up') // Suitable icon
            ,
        ];
    }
}

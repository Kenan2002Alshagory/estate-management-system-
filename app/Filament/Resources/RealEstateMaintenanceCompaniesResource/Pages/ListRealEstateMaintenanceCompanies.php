<?php

namespace App\Filament\Resources\RealEstateMaintenanceCompaniesResource\Pages;

use App\Filament\Resources\RealEstateMaintenanceCompaniesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRealEstateMaintenanceCompanies extends ListRecords
{
    protected static string $resource = RealEstateMaintenanceCompaniesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

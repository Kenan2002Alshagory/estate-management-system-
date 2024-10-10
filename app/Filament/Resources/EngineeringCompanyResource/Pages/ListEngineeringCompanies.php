<?php

namespace App\Filament\Resources\EngineeringCompanyResource\Pages;

use App\Filament\Resources\EngineeringCompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEngineeringCompanies extends ListRecords
{
    protected static string $resource = EngineeringCompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

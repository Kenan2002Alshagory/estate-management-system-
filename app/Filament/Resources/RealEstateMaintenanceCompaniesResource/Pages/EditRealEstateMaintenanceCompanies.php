<?php

namespace App\Filament\Resources\RealEstateMaintenanceCompaniesResource\Pages;

use App\Filament\Resources\RealEstateMaintenanceCompaniesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRealEstateMaintenanceCompanies extends EditRecord
{
    protected static string $resource = RealEstateMaintenanceCompaniesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['contact_information'])) {
            $contactInfo = $data['contact_information'];
            $data['phone'] = $contactInfo['phone'] ?? null;
            $data['email'] = $contactInfo['email'] ?? null;
            $data['website'] = $contactInfo['website'] ?? null;
            $data['whatsapp'] = $contactInfo['whatsapp'] ?? null;
            $data['telegram'] = $contactInfo['telegram'] ?? null;
            $data['instagram'] = $contactInfo['instagram'] ?? null;
            $data['facebook'] = $contactInfo['facebook'] ?? null;
            $data['twitter'] = $contactInfo['twitter'] ?? null;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['contact_information'] = json_encode([
            'phone' => $data['phone'],
            'email' => $data['email'],
            'website' => $data['website'],
            'whatsapp' => $data['whatsapp'],
            'telegram' => $data['telegram'],
            'instagram' => $data['instagram'],
            'facebook' => $data['facebook'],
            'twitter' => $data['twitter'],
        ]);

        // Remove individual fields from the data array
        unset($data['phone'], $data['email'], $data['website'], $data['whatsapp'], $data['telegram'], $data['instagram'], $data['facebook'], $data['twitter']);

        return $data;
    }
}

<?php

namespace App\Filament\Resources\EngineeringCompanyResource\Pages;

use App\Filament\Resources\EngineeringCompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEngineeringCompany extends CreateRecord
{
    protected static string $resource = EngineeringCompanyResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
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

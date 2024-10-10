<?php

namespace App\Filament\Resources\OfficeResource\Pages;

use App\Filament\Resources\OfficeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateOffice extends CreateRecord
{
    protected static string $resource = OfficeResource::class;

    // This method is used to combine first name and last name before saving
    public  function mutateFormDataBeforeCreate(array $data): array
    {

        // Hash password
        $data['password'] = Hash::make($data['password']);
        unset($data['password_confirmation']);

        return $data;
    }


}

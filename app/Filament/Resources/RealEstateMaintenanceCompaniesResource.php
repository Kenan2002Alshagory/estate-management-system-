<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RealEstateMaintenanceCompaniesResource\Pages;
use App\Filament\Resources\RealEstateMaintenanceCompaniesResource\RelationManagers;
use App\Models\Company;
use App\Models\RealEstateMaintenanceCompanies;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables;
use Filament\Tables\Table;
use Dotswan\MapPicker\Fields\Map;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RealEstateMaintenanceCompaniesResource extends Resource
{
    protected static ?string $model = Company::class;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationGroup= 'Companies' ;

    public static function getNavigationGroup(): ?string
    {
        return __('Companies') ;
    }

    public static function getLabel(): ?string
     {
         return __('Real Estate Maintenance Companies');
     }

     public static function getModelLabel(): string
     {
         return __('Real Estate Maintenance Companies');
     }
     public static function getNavigationLabel(): string
     {
         return __('Real Estate Maintenance Companies');
     }
    public static function getPluralLabel(): ?string
    {
        return __('Real Estate Maintenance Companies');
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes()->where('type', 'real_estate_maintenance_companies');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->label(__('Image'))
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label(__('Description'))
                    ->required(),
                Forms\Components\TextInput::make('location')
                    ->label(__('Location'))
                    ->required(),
                Forms\Components\Hidden::make('type')
                    ->default('real_estate_maintenance_companies'),
                Forms\Components\TextInput::make('phone')
                    ->label(__('Phone'))
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label(__('Email'))
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('website')
                    ->label(__('Website'))
                    ->required(),
                Forms\Components\TextInput::make('whatsapp')
                    ->label(__('WhatsApp')),
                Forms\Components\TextInput::make('telegram')
                    ->label(__('Telegram')),
                Forms\Components\TextInput::make('instagram')
                    ->label(__('Instagram')),
                Forms\Components\TextInput::make('facebook')
                    ->label(__('Facebook')),
                Forms\Components\TextInput::make('twitter')
                    ->label(__('Twitter')),
                Map::make('geo_location')
                    ->label('Location')
                    ->default([
                        'lat' => 40.4168,
                        'lng' => -3.7038
                    ])
                    ->afterStateHydrated(function ($state, $record, $set) {
                        // If the record exists and geolocation data is present
                        if ($record && $record->geolocation) {
                            $geolocation = json_decode($record->geolocation, true); // Decode JSON
                            if (isset($geolocation['lat']) && isset($geolocation['lng'])) {
                                // Set the lat/lng values from the record's geolocation
                                $set('geo_location',[
                                    'lat' => $geolocation['lat'],
                                    'lng' => $geolocation['lng'],
                                ]);
                            }
                        }
                    })
                    ->afterStateUpdated(function ($state, $set) {
                        // Encode the lat and lng values to JSON before saving
                        if (is_array($state) && isset($state['lat']) && isset($state['lng'])) {
                            $set('geo_location', json_encode(['lat' => $state['lat'], 'lng' => $state['lng']]));
                        }
                    })
                    ->liveLocation() // Enable live location
                    ->showMarker() // Show the marker on the map
                    ->draggable() // Allow the marker to be draggable
                    ->zoom(15) // Set initial zoom level
                    ->tilesUrl("https://tile.openstreetmap.de/{z}/{x}/{y}.png") // Use free OSM tiles
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label(__('Location'))
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('block')
                    ->label(__('Block')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('block')
                    ->options([
                        1 => 'Blocked',
                        0 => 'Active',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRealEstateMaintenanceCompanies::route('/'),
            'create' => Pages\CreateRealEstateMaintenanceCompanies::route('/create'),
            'edit' => Pages\EditRealEstateMaintenanceCompanies::route('/{record}/edit'),
        ];
    }
}

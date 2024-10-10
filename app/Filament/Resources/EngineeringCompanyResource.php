<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EngineeringCompanyResource\Pages\CreateEngineeringCompany;
use App\Filament\Resources\EngineeringCompanyResource\Pages\EditEngineeringCompany;
use App\Filament\Resources\EngineeringCompanyResource\Pages\ListEngineeringCompanies;
use App\Models\Company;
use Dotswan\MapPicker\Fields\Map;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EngineeringCompanyResource extends Resource
{
    protected static ?string $model = Company::class;
    protected  static ?string $navigationGroup= 'Companies' ;
    protected static  ?string $navigationIcon = "heroicon-o-building-office-2";
    public static function getNavigationGroup(): ?string
    {
        return __('Companies') ;
    }
    public static function getLabel(): ?string
    {
        return __('Engineering Company'); // TODO: Change the autogenerated stub
    }

    public static function getModelLabel(): string
    {
        return __('Engineering Company'); // TODO: Change the autogenerated stub
    }

    public static function getNavigationLabel(): string
    {
        return __('Engineering Company');
    }
    public static function getPluralLabel(): ?string
    {
        return __('Engineering Company');
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes()->where('type', 'engineering_companies');
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
                    ->default('engineering_companies'),

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
                    ->label(__('WhatsApp'))
                ,
                Forms\Components\TextInput::make('telegram')
                    ->label(__('Telegram'))
                ,
                Forms\Components\TextInput::make('instagram')
                    ->label(__('Instagram'))
                ,
                Forms\Components\TextInput::make('facebook')
                    ->label(__('Facebook'))
                ,
                Forms\Components\TextInput::make('twitter')
                    ->label(__('Twitter'))
                ,Map::make('geo_location')
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
                                $set('geo_location', [
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
                    ->label(__('Block'))
                ,
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
            'index' => ListEngineeringCompanies::route('/'),
            'create' => CreateEngineeringCompany::route('/create'),
            'edit' => EditEngineeringCompany::route('/{record}/edit'),
        ];
    }
}
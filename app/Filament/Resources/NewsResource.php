<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use App\Models\NewsDepartment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';


    public static function getLabel(): string
    {
        return __('News');
    }

    public static function getPluralLabel(): string
    {
        return __('News');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label(__('Title'))->columnSpan(2),

                Forms\Components\Textarea::make('body')
                    ->required()
                    ->label(__('Body'))->columnSpan(2),

                Forms\Components\FileUpload::make('image')
                    ->required()
                    ->directory('news_images')
                    ->label(__('Image'))
                ->columnSpan(2),

                // Repeater for the news_departments
                Forms\Components\Repeater::make('news_departments')
                    ->relationship('departments') // This should be set up in the model relationship
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('Title'))
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('body')
                            ->label(__('Body'))
                            ->nullable(),
                        Forms\Components\FileUpload::make('video')
                            ->label(__('Video'))
                            ->nullable()
                            ->directory('news_department_videos'),
                    ])
                    ->required() // Make the repeater required
                    ->minItems(1) // Ensure at least one department is required
                    ->label(__('News Departments'))->columnSpan(2),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('body')
                    ->label(__('Body'))
                    ->limit(50),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('Image')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
    public static function getNavigationSort(): ?int
    {
    return 7 ;
    }
}

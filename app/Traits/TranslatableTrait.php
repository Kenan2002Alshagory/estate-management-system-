<?php
namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use function Filament\Support\get_model_label;
use Illuminate\Support\Str;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\Column;

trait TranslatableTrait
{
    public static function initializeTranslatableTrait()
    {
        static::setupFormTranslation();
        static::setupColumnsTranslation();
    }

    protected static function setupFormTranslation()
    {
        Field::configureUsing(function ($field) {
            $fieldName = $field->getName();
            $fieldLabel = Str::of($fieldName)
                ->replace('.', ' ')
                ->headline();
            $field->label($fieldLabel)->translateLabel();
        });
    }

    protected static function setupColumnsTranslation()
    {
        Column::configureUsing(function ($column) {
            $columnName = $column->getName();
            $columnLabel = Str::of($columnName)
                ->replace('.', ' ')
                ->headline();
            $column->label($columnLabel)->translateLabel();
        });
    }

    public static function getModelLabel(): string
    {
        $locale = app()->getLocale();
        return Cache::remember('model_label_singular_' . static::class . '_' . $locale, 3600, function () use ($locale) {
            app()->setLocale($locale);
            return __(Str::headline(get_model_label(static::getModel())));
        });
    }

    public static function getPluralModelLabel(): string
    {
        $locale = app()->getLocale();
        return Cache::remember('model_label_plural_' . static::class . '_' . $locale, 3600, function () use ($locale) {
            app()->setLocale($locale);
            return __(Str::plural(Str::headline(get_model_label(static::getModel()))));
        });
    }

}

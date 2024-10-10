<?php
namespace App\Filament\Pages;

use App\Traits\TranslatableTrait;
use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\File;
use Filament\Notifications\Notification;

class AppInfoPage extends Page
{
    use TranslatableTrait;
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static string $view = 'filament.pages.app-info-page';

    public static function getNavigationLabel(): string
    {
        return __('app_info');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Setting');
    }

    public $whatsapp;
    public $telegram;
    public $instagram;
    public $facebook;
    public $twitter;

    public $ceo_number;
    public $advertisement_number;
    public $support_number;
    public $representative_number;
    public $real_estate_advisor_number;
    public $legal_advisor_number;
    public $real_estate_maintenance_number;
    public $investment_advisor_number;
    public $administration_number;
    public $privacy_policy;
    public $about_us;

    public function mount()
    {
        // Load the values from JSON if available
        if (File::exists(storage_path('app_info.json'))) {
            $data = json_decode(File::get(storage_path('app_info.json')), true);
            $this->whatsapp = $data['whatsapp'] ?? null;
            $this->telegram = $data['telegram'] ?? null;
            $this->instagram = $data['instagram'] ?? null;
            $this->facebook = $data['facebook'] ?? null;
            $this->twitter = $data['twitter'] ?? null;

            $this->ceo_number = $data['ceo_number'] ?? null;
            $this->advertisement_number = $data['advertisement_number'] ?? null;
            $this->support_number = $data['support_number'] ?? null;
            $this->representative_number = $data['representative_number'] ?? null;
            $this->real_estate_advisor_number = $data['real_estate_advisor_number'] ?? null;
            $this->legal_advisor_number = $data['legal_advisor_number'] ?? null;
            $this->real_estate_maintenance_number = $data['real_estate_maintenance_number'] ?? null;
            $this->investment_advisor_number = $data['investment_advisor_number'] ?? null;
            $this->administration_number = $data['administration_number'] ?? null;
            $this->privacy_policy = $data['privacy_policy'] ?? null;
            $this->about_us = $data['about_us'] ?? null;
        }
    }

    protected function getFormSchema(): array
    {
        return [
            // Social Media Section
            Forms\Components\Section::make(__('social_media_section'))
                ->schema([
                    Forms\Components\TextInput::make('whatsapp')->label('WhatsApp')->required(),
                    Forms\Components\TextInput::make('telegram')->label('Telegram')->required(),
                    Forms\Components\TextInput::make('instagram')->label('Instagram')->required(),
                    Forms\Components\TextInput::make('facebook')->label('Facebook')->required(),
                    Forms\Components\TextInput::make('twitter')->label('Twitter')->required(),
                ]),

            // Formal Numbers Section
            Forms\Components\Section::make(__('formal_numbers_section'))
                ->schema([
                    Forms\Components\TextInput::make('ceo_number')->label(__('ceo_number'))->required(),
                    Forms\Components\TextInput::make('advertisement_number')->label(__('advertisement_number'))->required(),
                ]),

            // Contact Section
            Forms\Components\Section::make(__('communication_section'))
                ->schema([
                    Forms\Components\TextInput::make('support_number')->label(__('support_number'))->required(),
                    Forms\Components\TextInput::make('representative_number')->label(__('representative_number'))->required(),
                    Forms\Components\TextInput::make('real_estate_advisor_number')->label(__('real_estate_advisor_number'))->required(),
                    Forms\Components\TextInput::make('legal_advisor_number')->label(__('legal_advisor_number'))->required(),
                    Forms\Components\TextInput::make('real_estate_maintenance_number')->label(__('real_estate_maintenance_number'))->required(),
                    Forms\Components\TextInput::make('investment_advisor_number')->label(__('investment_advisor_number'))->required(),
                    Forms\Components\TextInput::make('administration_number')->label(__('administration_number'))->required(),
                ]),

            Forms\Components\Section::make(__('privacy_policy'))
                ->schema([
                    Forms\Components\Textarea::make('privacy_policy')->label(__('Privacy_policy'))->required(),
                ]),

            Forms\Components\Section::make(__('about_us'))
                ->schema([
                    Forms\Components\Textarea::make('about_us')->label(__('About_us'))->required(),
                ]),

        ];
    }

    public function submit()
    {
        // Validate form inputs
        $data = $this->validate();

        // Prepare JSON data to store
        $jsonData = [
            'whatsapp' => $data['whatsapp'],
            'telegram' => $data['telegram'],
            'instagram' => $data['instagram'],
            'facebook' => $data['facebook'],
            'twitter' => $data['twitter'],

            'ceo_number' => $data['ceo_number'],
            'advertisement_number' => $data['advertisement_number'],
            'support_number' => $data['support_number'],
            'representative_number' => $data['representative_number'],
            'real_estate_advisor_number' => $data['real_estate_advisor_number'],
            'legal_advisor_number' => $data['legal_advisor_number'],
            'real_estate_maintenance_number' => $data['real_estate_maintenance_number'],
            'investment_advisor_number' => $data['investment_advisor_number'],
            'administration_number' => $data['administration_number'],
            'privacy_policy' => $data['privacy_policy'],
            'about_us' => $data['about_us']
        ];

        // Save the data to a JSON file
        File::put(storage_path('app_info.json'), json_encode($jsonData, JSON_PRETTY_PRINT));

        // Success notification
        Notification::make()
            ->title('Contact Information saved successfully.')
            ->success()
            ->send();
    }

    public static function getNavigationSort(): ?int
    {
        return 9 ;
    }

}

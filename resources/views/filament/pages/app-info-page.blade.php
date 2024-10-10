<x-filament::page>
    <div class="space-y-6">
        <x-filament::card>
            <form wire:submit.prevent="submit" class="space-y-6">
                {{ $this->form }}

                <div class="flex justify-end">
                    <x-filament::button type="submit" class="bg-primary-600 hover:bg-primary-700 focus:ring-primary-500">
                        حفظ التعديلات
                    </x-filament::button>
                </div>
            </form>
        </x-filament::card>
    </div>
</x-filament::page>

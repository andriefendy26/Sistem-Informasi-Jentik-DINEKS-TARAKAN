<x-filament-panels::page>
    <form wire:submit="kirim">
        {{ $this->form }}

        <div class="mt-6">
            <x-filament::button type="submit">
                Kirim Laporan
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Pilih Periode</x-slot>
        {{ $this->form }}
    </x-filament::section>

    <div class="flex gap-4 mt-4">
        <x-filament::button wire:click="downloadPemeriksaan">
            Export Laporan Hasil Pemeriksaan Jentik
        </x-filament::button>

        <x-filament::button wire:click="downloadPerRt" color="gray">
            Export Rekap Pendataan per RT
        </x-filament::button>
    </div>
</x-filament-panels::page>
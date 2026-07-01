<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-[1fr_60px_1fr] gap-y-4 mb-6">
        <x-filament::section>
            <x-slot name="heading">Kelengkapan Laporan Bulan Ini</x-slot>

            <div class="text-3xl font-bold">
                {{ $this->getKelengkapanPercentage() }}%
            </div>

            <p class="text-sm text-gray-500">
                RT yang sudah melapor bulan ini
            </p>
        </x-filament::section>

        <x-filament::section class="md:col-start-3">
            <x-slot name="heading">Ketepatan Waktu Pelaporan (Max Tgl 5)</x-slot>

            <div class="text-3xl font-bold">
                {{ $this->getKetepatanPercentage() }}%
            </div>

            <p class="text-sm text-gray-500">
                Laporan yang masuk sebelum/tanggal 5
            </p>
        </x-filament::section>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
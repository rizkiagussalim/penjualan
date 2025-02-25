<x-filament-panels::page>
    <div class="space-y-4">
        <img src="{{ Storage::url($record->photo) }}" alt="{{ $record->name }}" class="w-64 h-64 rounded-lg mx-auto">
        <h2 class="text-2xl font-bold text-center">{{ $record->name }}</h2>
        <p class="text-center text-gray-500">Rp {{ number_format($record->price, 0, ',', '.') }}</p>
        <p class="text-center text-gray-400">Stok: {{ $record->stock }}</p>
        <p class="text-justify">{{ $record->description }}</p>
    </div>
</x-filament-panels::page>

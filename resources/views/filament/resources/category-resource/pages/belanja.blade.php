<x-filament::page>
    <div class="space-y-6">
        <!-- Tabs Kategori -->
        <div class="flex space-x-4 overflow-x-auto pb-4">
            <a href="{{ route('filament.resources.category-resource.pages.belanja') }}"
            class="px-4 py-2 rounded-lg {{ !$selectedCategory ? 'bg-primary-500 text-white' : 'bg-gray-200' }}">
            Semua
         </a>

         @foreach ($categories as $category)
             <a href="{{ route('filament.resources.category-resource.pages.belanja', ['selectedCategory' => $category->id]) }}"
                class="px-4 py-2 rounded-lg {{ $selectedCategory == $category->id ? 'bg-primary-500 text-white' : 'bg-gray-200' }}">
                {{ $category->name }}
             </a>
         @endforeach

        </div>

        <!-- Grid Produk -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <img src="{{ Storage::url($product->photo) }}" alt="{{ $product->name }}"
                        class="w-full h-48 object-cover">
                    <div class="p-4 space-y-2">
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <p class="text-primary-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <button
                            class="w-full bg-primary-500 text-white py-2 rounded-lg hover:bg-primary-600 transition">
                            Beli
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-center col-span-4">Produk tidak ditemukan.</p>
            @endforelse
        </div>
    </div>
</x-filament::page>

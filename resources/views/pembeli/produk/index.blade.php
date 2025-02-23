@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Daftar Produk</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($produk as $item)
            <div class="border rounded-lg p-4 shadow">
                <img src="{{ asset('storage/'.$item->photo) }}" class="w-full h-48 object-cover mb-2">
                <h3 class="text-lg font-semibold">{{ $item->name }}</h3>
                <p class="text-gray-600">Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                <a href="{{ route('produk.show', $item->id) }}" class="text-blue-500">Lihat Detail</a>
            </div>
        @endforeach
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold">{{ $produk->name }}</h2>
    <img src="{{ asset('storage/'.$produk->photo) }}" class="w-full h-64 object-cover mb-4">
    <p class="text-gray-700">{{ $produk->description }}</p>
    <p class="text-xl font-semibold mt-2">Rp{{ number_format($produk->price, 0, ',', '.') }}</p>
    <button class="bg-green-500 text-white px-4 py-2 rounded mt-4">Beli Sekarang</button>
</div>
@endsection

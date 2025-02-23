<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Product::all();
        return view('pembeli.produk.index', compact('produk'));
    }

    public function show($id)
    {
        $produk = Product::findOrFail($id);
        return view('pembeli.produk.show', compact('produk'));
    }
}

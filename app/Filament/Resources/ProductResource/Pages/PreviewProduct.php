<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\Page;
use App\Models\Product;

class PreviewProduct extends Page
{
    protected static string $resource = ProductResource::class;

    protected static string $view = 'filament.resources.product-resource.pages.preview-product';

    public Product $record;

    public function mount(Product $record): void
    {
        $this->record = $record;
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TextFilter;
use App\Traits\HasDynamicPermission;
use Filament\Tables\Filters\Filter;

class ProductResource extends Resource
{
    use HasDynamicPermission;

    protected static function getPermissionName(): string
    {
        return 'products';
    }

    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Produk';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('category_id')
                ->label('Kategori')
                ->relationship('category', 'name')
                ->required(),

            TextInput::make('name')
                ->label('Nama Produk')
                ->required()
                ->placeholder('Masukkan nama produk...'),

            TextInput::make('price')
                ->label('Harga')
                ->numeric()
                ->prefix('Rp')
                ->required(),

            TextInput::make('stock')
                ->label('Stok')
                ->numeric()
                ->required(),

            FileUpload::make('photo')
                ->label('Foto Produk')
                ->image()
                ->imagePreviewHeight('250')
                ->directory('products')
                ->columnSpanFull(),

            Textarea::make('description')
                ->label('Deskripsi Produk')
                ->rows(5)
                ->placeholder('Masukkan deskripsi produk...')
                ->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        if (auth()->user()->hasRole('pembeli')) {
            return $table
                ->columns([
                    ImageColumn::make('photo')
                        ->label('Foto Produk')
                        ->circular()
                        ->width(120)
                        ->height(120),

                    TextColumn::make('name')
                        ->label('Nama Produk')
                        ->searchable()
                        ->sortable(),

                    TextColumn::make('price')
                        ->label('Harga')
                        ->sortable()
                        ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                ])
                ->filters([
                    Filter::make('name')
                        ->label('Cari Produk')
                        ->query(function ($query, $data) {
                            return $query->where('name', 'like', '%' . $data . '%');
                        }),
                    SelectFilter::make('category_id')->label('Kategori')->relationship('category', 'name'),
                    SelectFilter::make('sort_price')
                        ->label('Urutkan Harga')
                        ->options([
                            'asc' => 'Harga Termurah',
                            'desc' => 'Harga Termahal',
                        ])
                        ->query(function ($query, $state) {
                            if ($state === 'asc') return $query->orderBy('price', 'asc');
                            if ($state === 'desc') return $query->orderBy('price', 'desc');
                        }),

                ])
                ->actions([
                    Action::make('preview')
                        ->label('Lihat Detail')
                        ->icon('heroicon-o-eye')
                        ->color('primary')
                        ->modalHeading('Detail Produk')
                        ->modalSubmitAction(false)
                        ->modalContent(fn (Product $record) => view('filament.resources.product-resource.pages.preview', ['record' => $record]))
                        ->modalWidth('4xl')
                        ->modalFooterActions([
                            Action::make('add_to_cart')
                                ->label('Masukkan ke Keranjang')
                                ->color('success')
                                ->icon('heroicon-o-shopping-cart')
                                ->action(fn () => session()->flash('message', 'Produk berhasil dimasukkan ke keranjang!')),
                        ]),
                ])
                ->paginationPageOptions([8, 16, 32])
                ->defaultPaginationPageOption(8);
        } else {
            return $table
                ->columns([
                    ImageColumn::make('photo')
                        ->label('Foto Produk')
                        ->circular()
                        ->width(100)
                        ->height(100),

                    TextColumn::make('name')
                        ->label('Nama Produk')
                        ->searchable()
                        ->sortable()
                        ->description(fn (Product $record) => 'Stok: ' . $record->stock . ' | Rp ' . number_format($record->price, 0, ',', '.')),

                    TextColumn::make('description')
                        ->label('Deskripsi')
                        ->limit(40),
                ])

                ->filters([
                    Filter::make('name')
                        ->label('Cari Produk')
                        ->query(function ($query, $data) {
                            return $query->where('name', 'like', '%' . $data . '%');
                        }),
                    SelectFilter::make('category_id')->label('Kategori')->relationship('category', 'name'),
                    SelectFilter::make('sort_price')
                        ->label('Urutkan Harga')
                        ->options([
                            'asc' => 'Harga Termurah',
                            'desc' => 'Harga Termahal',
                        ])
                        ->query(function ($query, $state) {
                            if ($state === 'asc') return $query->orderBy('price', 'asc');
                            if ($state === 'desc') return $query->orderBy('price', 'desc');
                        }),
                ])
                ->actions([
                    Tables\Actions\EditAction::make()->label('Edit')->icon('heroicon-o-pencil'),
                    Tables\Actions\DeleteAction::make()->label('Hapus')->icon('heroicon-o-trash')->color('danger'),
                ])
                ->paginationPageOptions([8, 16, 32])
                ->defaultPaginationPageOption(8);
        }
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'preview' => Pages\PreviewProduct::route('/{record}/preview'),
        ];
    }
}

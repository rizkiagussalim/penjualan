<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;




class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('category_id')
                ->label('Kategori')
                ->relationship('category', 'name')
                ->required(),
            TextInput::make('name')
                ->label('Nama Produk')
                ->required(),
            TextInput::make('price')
                ->label('Harga')
                ->numeric()
                ->required(),
            TextInput::make('stock')
                ->label('Stok')
                ->numeric()
                ->required(),
            FileUpload::make('photo')
                ->label('Foto Produk')
                ->image()
                ->directory('products'),
                Textarea::make('description')->label('Deskripsi Produk')->rows(5),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto Produk')
                    ->circular() // Foto berbentuk bulat (opsional)
                    ->width(80)   // Atur ukuran foto (opsional)
                    ->height(80),

                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable() // Bisa dicari jika banyak produk
                    ->sortable(),  // Bisa diurutkan

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', true) // Format harga (IDR: Rupiah)
                    ->sortable(),

                    TextColumn::make('description')->label('Deskripsi')->limit(50),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

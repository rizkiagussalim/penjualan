<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Traits\HasDynamicPermission;
use Spatie\Permission\Models\Permission;

class RoleResource extends Resource
{
    use HasDynamicPermission;

    protected static function getPermissionName(): string
    {
        return 'roles';
    }

    protected static ?string $model = Role::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Manajemen Role';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Role')
                    ->description('Isi informasi detail untuk role yang akan dibuat.')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Role')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50)
                                    ->placeholder('Masukkan nama role...')
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('guard_name')
                                    ->label('Guard Name')
                                    ->default('web')
                                    ->disabled()
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsed(false),

                Forms\Components\Section::make('Akses / Permissions')
                    ->description('Kelola akses yang dimiliki role ini.')
                    ->schema([
                        Forms\Components\CheckboxList::make('permissions')
                            ->label('Daftar Permissions')
                            ->relationship('permissions', 'name')
                            ->columns(4) // ✅ 4 kolom untuk tampilan lebih rapi
                            ->required()
                            ->searchable()
                            ->extraAttributes(['class' => 'permissions-checkbox'])
                            ->hint('Gunakan tombol toggle untuk memilih semua akses.')
                            ->hintAction(
                                Forms\Components\Actions\Action::make('toggle_all')
                                    ->label('Toggle Select All')
                                    ->color('success')
                                    ->icon('heroicon-o-adjustments-vertical')
                                    ->action(function ($state, callable $set) {
                                        $allPermissions = Permission::all()->pluck('id')->toArray();
                                        $set('permissions', count($state ?? []) < count($allPermissions) ? $allPermissions : []);
                                    })
                                    ->tooltip('Klik untuk memilih atau menghapus semua permissions')
                            ),
                    ])
                    ->columns(1)
                    ->collapsed(false),
            ])
            ->columns(1); // ✅ Ukuran form dibuat compact dan rapi
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Nama Role')
                    ->badge(),

                Tables\Columns\TextColumn::make('guard_name')
                    ->label('Guard')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label('Total Akses')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->label('Tanggal Dibuat'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('guard_name')
                    ->label('Filter Guard')
                    ->options([
                        'web' => 'Web',
                        'api' => 'API',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->color('warning')
                    ->icon('heroicon-o-pencil-square'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->color('danger')
                    ->icon('heroicon-o-trash'),
            ])
            ->striped()
            ->defaultSort('created_at', 'desc');
    }

    public static function afterUpdate(Role $role, array $data): void
    {
        $role->syncPermissions($data['permissions']);
    }

    public static function afterCreate(Role $role, array $data): void
    {
        $role->syncPermissions($data['permissions']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}

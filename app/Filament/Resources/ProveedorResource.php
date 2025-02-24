<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProveedorResource\Pages;
use App\Models\Proveedor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;

class ProveedorResource extends Resource
{
    protected static ?string $model = Proveedor::class;
    protected static ?string $navigationLabel = 'Proveedores';//nombre del archivo de la carpeta 
    protected static ?string $modelLabel = 'Proveedore'; //nobre de la lista
    protected static ?string $navigationGroup = 'Productos';//nombre de la carpeta
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary'; 
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_comercial')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefono_1')
                    ->tel()
                    ->maxLength(20),
                Forms\Components\TextInput::make('telefono_2')
                    ->tel()
                    ->nullable()
                    ->maxLength(20),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\Textarea::make('direccion_1')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('direccion_2')
                    ->nullable()
                    ->maxLength(65535),
                Forms\Components\TextInput::make('ciudad')
                    ->maxLength(255),
                Forms\Components\Select::make('estado_proveedor')
                    ->options([
                        'activo' => 'Activo',
                        'inactivo' => 'Inactivo',
                        'suspendido' => 'Suspendido',
                    ])
                    ->default('activo'),
                Forms\Components\Textarea::make('comentarios')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_proveedor')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nombre_comercial')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('telefono_1')->sortable(),
                Tables\Columns\TextColumn::make('telefono_2')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('direccion_1')->sortable(),
                Tables\Columns\TextColumn::make('direccion_2')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ciudad')->sortable(),
                Tables\Columns\BadgeColumn::make('estado_proveedor')
            ->colors([
                'success' => 'activo',
                'warning' => 'inactivo',
                'danger' => 'suspendido',
                    ])
            ->formatStateUsing(fn ($state) => ucfirst($state)),
            TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->date()
                    ->sortable()
                    ->dateTooltip()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Fecha de Actualización')
                    ->date()
                    ->sortable()
                    ->dateTooltip()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProveedor::route('/'),
            'create' => Pages\CreateProveedor::route('/create'),
            'edit' => Pages\EditProveedor::route('/{record}/edit'),
        ];
    }
}

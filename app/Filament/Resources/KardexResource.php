<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KardexResource\Pages;
use App\Models\Kardex;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class KardexResource extends Resource
{
    protected static ?string $model = Kardex::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Kardex';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('id_producto')
                    ->relationship('producto', 'nombre')
                    ->required(),
                
                Select::make('id_venta')
                    ->relationship('venta', 'id_venta') // Relaciona automáticamente con la venta
                    ->nullable(),
                
                Select::make('id_compra')
                    ->relationship('compra', 'id_compra') // Relaciona con la compra
                    ->nullable(),
                
                Select::make('id_proveedor')
                    ->relationship('proveedor', 'nombre')
                    ->nullable(),
                
                Select::make('id_usuario')
                    ->relationship('usuario', 'nombre')
                    ->nullable(),
                
                Select::make('tipo')
                    ->options([
                        'venta' => 'Venta',
                        'compra' => 'Compra'
                    ])
                    ->required(),
                
                TextInput::make('cantidad')
                    ->numeric()
                    ->required(),
                
                TextInput::make('total')
                    ->numeric()
                    ->required(),
                
                Textarea::make('descripcion')
                    ->nullable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id_kardex')->label('ID')->sortable(),
                TextColumn::make('producto.nombre')->label('Producto'),
                TextColumn::make('venta.id_venta')->label('ID Venta'), // Relaciona la venta
                TextColumn::make('tipo')->label('Tipo')->sortable(),
                TextColumn::make('cantidad')->label('Cantidad'),
                TextColumn::make('total')->label('Total')->money('USD'),
                TextColumn::make('descripcion')->label('Descripción'),
                TextColumn::make('fecha')->label('Fecha')->dateTime(),
            ])
            ->filters([
                // Filtros si es necesario
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKardexes::route('/'),
            'create' => Pages\CreateKardex::route('/create'),
            'edit' => Pages\EditKardex::route('/{record}/edit'),
        ];
    }
}

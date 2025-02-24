<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Models\Producto;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Productos'; 
    protected static ?string $modelLabel = 'Producto'; 
    protected static ?string $navigationGroup = 'Productos';
    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary'; 
    }

    // Formulario de creación y edición de productos
    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('nombre')
                ->required()
                ->maxLength(255)
                ->label('Nombre Producto'),
            Section::make('Descripción del Producto')
                ->schema([
                    Forms\Components\Textarea::make('descripcion')
                        ->label('Descripción del Producto')
                        ->rows(4),
                ])
                ->collapsible(),
            Forms\Components\TextInput::make('precio')
                ->required()
                ->numeric()
                ->label('Precio'),
            Forms\Components\TextInput::make('cantidad')
                ->required()
                ->numeric()
                ->label('Cantidad'),
            Forms\Components\Select::make('estado_producto')
                ->options([
                    'activo' => 'Activo',
                    'inactivo' => 'Inactivo',
                    'agotado' => 'Agotado',
                ])
                ->default('activo')
                ->label('Estado del Producto'),
            Forms\Components\Select::make('id_categoria')
                ->relationship('categoria', 'nombre_categoria') // Relación con la tabla de categorías
                ->required()
                ->label('Categoría del Producto'),
                Forms\Components\Select::make('id_proveedor')
                ->options(
                    \App\Models\Proveedor::all()->pluck('nombre_comercial', 'id_proveedor')->toArray()
                ) // Esto obtiene todos los proveedores y sus ids
                ->required()
                ->label('Proveedor')
                ->searchable(),
            
        ]);
}

    

    // Definición de la tabla de productos
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_producto')
                    ->label('id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nombre')
                    ->label('Nombre Producto')
                    ->searchable(),
                TextColumn::make('descripcion')
                    ->label('Descripción'),
                TextColumn::make('precio')
                   ->money('hnl')
                    ->label('Precio'),
                TextColumn::make('cantidad')
                    ->label('Cantidad'),
                BadgeColumn::make('estado_producto')
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->colors([
                        'success' => 'activo',
                        'danger' => 'inactivo',
                        'warning' => 'agotado',
                    ])
                    ->sortable(),
                // Relacionamos el proveedor para mostrar su nombre en lugar del ID
                TextColumn::make('proveedor.nombre_comercial')
                ->label('Proveedor')
                ->sortable(),
                TextColumn::make('categoria.nombre_categoria')
                ->label('Categoria')
                ->sortable(),
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
            ->filters([ 
                // Filtros si es necesario
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Acción para editar
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Acción para eliminar en bulk
                ]),
            ]);
    }
    

    // Relaciones si las necesitas, en este caso no hay ninguna otra relación
    public static function getRelations(): array
    {
        return [
            // Relaciones si las necesitas
        ];
    }

    // Páginas para los productos
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}

<?php
namespace App\Filament\Resources;

use App\Filament\Resources\DetalleVentaResource\Pages;
use App\Models\DetalleVenta;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Producto;

class DetalleVentaResource extends Resource
{
    protected static ?string $model = DetalleVenta::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Detalles de Venta';
    protected static ?string $modelLabel = 'Detalle de Venta';
    protected static ?string $navigationGroup = 'Administrador de Ventas';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'secondary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Relación con la tabla ventas utilizando 'id_venta'
                Forms\Components\Select::make('id_venta')
                ->label('Venta')
                ->required()
                ->relationship(
                    'venta', 
                    'id_venta', 
                    fn ($query) => $query->join('tbl_clientes', 'tbl_ventas.id_cliente', '=', 'tbl_clientes.id')
                        ->selectRaw("tbl_ventas.id_venta, CONCAT(tbl_clientes.primer_nombre, ' ', tbl_clientes.primer_apellido, ' - Venta ID: ', tbl_ventas.id_venta) as cliente_venta")
                )
                ->getOptionLabelFromRecordUsing(fn ($record) => $record->cliente_venta),
            
            

                // Relación con productos
                Forms\Components\Select::make('id_producto')
                ->relationship('producto', 'nombre')  // Relación con productos por nombre
                ->label('Producto')
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    if (!$state) {
                        $set('precio_unitario', 0); // Si no hay producto seleccionado, poner 0
                        return;
                    }
            
                    $producto = Producto::find($state); // Buscar el producto seleccionado
            
                    if ($producto) {
                        $set('precio_unitario', $producto->precio);
                    } else {
                        $set('precio_unitario', 0); // Si no se encuentra el producto, poner 0
                    }
                }),
                      
            
                // Campo cantidad
                Forms\Components\TextInput::make('cantidad')
                ->numeric()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, $get) {
                    $precio_unitario = $get('precio_unitario');
                    $descuento = $get('descuento');
                    if ($precio_unitario && $state) {
                        $precio_con_descuento = $precio_unitario - ($precio_unitario * ($descuento / 100));
                        $set('subtotal', $precio_con_descuento * $state); // Actualizar el subtotal
                    }
                }),

            // Precio unitario (debe ser readOnly, no disabled)
            Forms\Components\TextInput::make('precio_unitario')
                ->numeric()
                ->readOnly(), // Cambiar disabled() por readOnly()

                // Campo de descuento (opcional)
                Forms\Components\TextInput::make('descuento')
                    ->numeric()
                    ->nullable()
                    ->default(0), // Valor predeterminado (si no se ingresa descuento)

                // Campo de subtotal
                Forms\Components\TextInput::make('subtotal')
                ->numeric()
                ->required()
                ->readOnly()  // Deshabilitar para que no lo editen manualmente
                ->default(0),          
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_detalle_ventas')->sortable(),
                Tables\Columns\TextColumn::make('venta.id_venta')->label('Venta')->sortable(),
                Tables\Columns\TextColumn::make('producto.nombre')->label('Producto')->searchable(),
                Tables\Columns\TextColumn::make('cantidad')->sortable(),
                Tables\Columns\TextColumn::make('producto.precio')->label('Precio Unitario')->sortable()->numeric(),
                Tables\Columns\TextColumn::make('subtotal')->label('Sub Total')->sortable()->numeric(),
            ])
            ->filters([ /* Filtros si es necesario */ ])
            ->actions([ Tables\Actions\EditAction::make() ])
            ->bulkActions([ Tables\Actions\BulkActionGroup::make([ Tables\Actions\DeleteBulkAction::make() ]) ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDetalleVentas::route('/'),
            'create' => Pages\CreateDetalleVenta::route('/create'),
            'edit' => Pages\EditDetalleVenta::route('/{record}/edit'),
        ];
    }
}

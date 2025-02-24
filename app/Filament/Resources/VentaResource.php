<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentaResource\Pages;
use App\Models\Venta;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Ventas';
    protected static ?string $modelLabel = 'Venta';
    protected static ?string $navigationGroup = 'Administrador de Ventas';
    protected static ?int $navigationSort = 1;

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
                Forms\Components\Select::make('id_cliente')
                    ->label('Cliente')
                    ->options(function () {
                        return \App\Models\Cliente::all()->pluck('primer_nombre', 'id')
                            ->mapWithKeys(function ($item, $key) {
                                $cliente = \App\Models\Cliente::find($key);
                                return [$key => $cliente->primer_nombre . ' ' . $cliente->primer_apellido]; // Concatenamos los dos campos
                            });
                    })
                    ->required(),
                
                Forms\Components\Select::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'completado' => 'Completado',
                        'cancelado' => 'Cancelado',
                    ])
                    ->required()
                    ->label('Estado de Venta'),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('id_venta')->sortable()->label('ID de Venta'),
            TextColumn::make('cliente.primer_nombre')->label('Primer Nombre Cliente')->searchable(),
            TextColumn::make('cliente.primer_apellido')->label('Apellido Cliente')->searchable(),
            TextColumn::make('total')->sortable()->numeric()->label('Total'),
            BadgeColumn::make('estado')
                ->formatStateUsing(fn ($state) => ucfirst($state))
                ->colors([
                    'success' => 'completado',
                    'warning' => 'pendiente',
                    'danger' => 'cancelado',
                ])
                ->sortable()
                ->label('Estado'),
        ])
        ->filters([
            // Filtros si es necesario
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVentas::route('/'),
            'create' => Pages\CreateVenta::route('/create'),
            'edit' => Pages\EditVenta::route('/{record}/edit'),
        ];
    }
}
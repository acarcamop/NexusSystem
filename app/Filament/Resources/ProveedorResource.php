<?php

namespace App\Filament\Resources;
use Illuminate\Validation\Rule;

use App\Filament\Resources\ProveedorResource\Pages;
use App\Models\Proveedor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProveedorResource extends Resource
{
    protected static ?string $model = Proveedor::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Proveedores'; 
    protected static ?string $modelLabel = 'Proveedores';
    protected static ?string $navigationGroup = 'Administración de Proveedores';
    protected static ?int $navigationSort = 3;

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
            Forms\Components\TextInput::make('nombre')
                ->required()
                ->maxLength(255)
                ->label('Nombre'),

            Forms\Components\TextInput::make('telefono')
                ->nullable()
                ->required()
                ->maxLength(255)
                ->label('Teléfono'),
                
                Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255)
                ->rules(function ($component) {
                    return [
                        'required',
                        'email',
                        Rule::unique('tbl_proveedores', 'email')->ignore($component->getRecord()->id_proveedor, 'id_proveedor'),
                    ];
                })
                ->label('Correo')
                ->validationMessages([
                    'unique' => 'Este correo ya está en uso. Por favor, ingresa otro.',
                ]),
            Forms\Components\TextInput::make('direccion')
                ->nullable()
                ->required()
                ->maxLength(255)
                ->label('Dirección'),

           

            Forms\Components\Textarea::make('informacion_adicional')
                ->nullable()
                ->label('Información Adicional'),

            Forms\Components\Select::make('estado_proveedor')
                ->options([
                    'activo' => 'Activo',
                    'inactivo' => 'Inactivo',
                    'suspendido' => 'Suspendido',
                ])
                ->required()
                ->label('Estado del Proveedor'),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_proveedor')
                ->label('ID')
                    ->searchable(),
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('telefono')
                ->searchable(),
                TextColumn::make('email')
                    ->label('Correo')
                    ->searchable(),
                TextColumn::make('direccion')
                    ->searchable(),
                
                TextColumn::make('telefono')
                    ->searchable(),

                BadgeColumn::make('estado_proveedor')
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->label('Estado')
                    ->colors([
                        'success' => 'activo',
                        'danger' => 'inactivo',
                        'warning' => 'suspendido',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha Creación')
                    ->date()
                    ->sortable()
                    ->dateTooltip()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Fecha Actualización')
                    ->date()
                    ->sortable()
                    ->dateTooltip()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('informacion_adicional')->label('Información Adicional')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ])
            ->defaultSort('created_at', 'desc'); // Ordenar por fecha de creación en orden descendente
    }

    public static function getRelations(): array
    {
        return [
            // Relaciones si las necesitas
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProveedores::route('/'),
            'create' => Pages\CreateProveedor::route('/create'),
            'edit' => Pages\EditProveedor::route('/{record}/edit'),
        ];
    }
}

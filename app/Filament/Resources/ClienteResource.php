<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Clientes'; 
    protected static ?string $modelLabel = 'Cliente';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('primer_nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('segundo_nombre')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\TextInput::make('primer_apellido')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('segundo_apellido')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email_1')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email_2')
                    ->email()
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefono_1')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefono_2')
                    ->tel()
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\TextInput::make('direccion_1')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('direccion_2')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\Textarea::make('informacion_adicional')
                    ->nullable(),
                    Forms\Components\Select::make('estado_cliente')
                    ->options([
                        'activo' => 'Activo',
                        'inactivo' => 'Inactivo',
                        'suspendido' => 'Suspendido',
                    ])
                    ->required()
                    ->label('Estado de Cliente'),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('id')
            ->searchable(),
            TextColumn::make('primer_nombre')
                ->searchable(),
            TextColumn::make('segundo_nombre')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('primer_apellido')
                ->searchable(),
            TextColumn::make('segundo_apellido')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            BadgeColumn::make('estado_cliente')
                ->formatStateUsing(fn ($state) => ucfirst($state))
                ->colors([
                    'success' => 'activo',
                    'danger' => 'inactivo',
                    'warning' => 'suspendido',
                ])
                ->sortable(),
            TextColumn::make('email_1')->label('Correo Electrónico 1')
                ->searchable(),
            TextColumn::make('email_2')->label('Correo Electrónico 2')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('telefono_1')->label('Teléfono 1')
                ->searchable(),
            TextColumn::make('telefono_2')->label('Teléfono 2')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            // Agregar las columnas para las direcciones
            TextColumn::make('direccion_1')->label('Dirección 1')
                ->searchable(),
            TextColumn::make('direccion_2')->label('Dirección 2')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
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
            TextColumn::make('informacion_adicional')->label('Informacion Adicional')
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
        ]);
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
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}

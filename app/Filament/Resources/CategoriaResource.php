<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoriaResource\Pages;
use App\Models\Categoria;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriaResource extends Resource
{
    protected static ?string $model = Categoria::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder'; 
    protected static ?string $navigationLabel = 'Categorías'; 
    protected static ?string $modelLabel = 'Categoría'; 
    protected static ?string $navigationGroup = 'Productos';
    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary'; 
    }
    // Formulario de creación y edición de categorías
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre_categoria')
                    ->required()
                    ->maxLength(255)
                    ->label('Nombre de la Categoría'),
                    Section::make('Descripción de la Categoria')
                    ->schema([
                        Forms\Components\Textarea::make('descripcion')
                 
                            ->label('Descripción de Categoria')
                            ->rows(4),
                    ])
                    ->collapsible(),
                    Forms\Components\Select::make('estado_categoria')
                    ->options([
                        'activa' => 'Activa',
                        'inactiva' => 'Inactiva',
                        'suspendida' => 'Suspendida',
                    ])
                    ->required()
                    ->label('Estado Categoria'),
            ]);
    }

    // Definición de la tabla de categorías
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_categoria')
                    ->label('id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nombre_categoria')
                    ->label('Nombre Categoría')
                    ->searchable(),
                TextColumn::make('descripcion')
                    ->label('Descripción'),
                    BadgeColumn::make('estado_categoria')
                ->formatStateUsing(fn ($state) => ucfirst($state))
                ->colors([
                    'success' => 'activa',
                    'danger' => 'inactiva',
                    'warning' => 'suspendid',
                ])
                ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Creación')
                    ->date()
                    ->sortable()
                    ->dateTooltip()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Fecha Actualización')
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

    // Relaciones si las necesitas, en este caso no hay ninguna relacionada
    public static function getRelations(): array
    {
        return [
            // Relaciones si las necesitas
        ];
    }

    // Páginas de la administración de las categorías
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategorias::route('/'),
            'create' => Pages\CreateCategoria::route('/create'),
            'edit' => Pages\EditCategoria::route('/{record}/edit'),
        ];
    }
}

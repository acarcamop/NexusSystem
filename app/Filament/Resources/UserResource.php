<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Usuarios'; 
    protected static ?string $modelLabel = 'Usuario';
    protected static ?string $navigationGroup = 'Administrador de Usuarios';
    protected static ?int $navigationSort = 2;

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
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->hidden(fn ($livewire) => $livewire instanceof Pages\EditUser)
                    ->maxLength(255),
                Forms\Components\Select::make('estado_usuario')
                    ->options([
                        'activo' => 'Activo',
                        'inactivo' => 'Inactivo',
                        'suspendido' => 'Suspendido',
                    ])
                    ->required()
                    ->label('Estado de Usuario'),
                Forms\Components\TextInput::make('correo_alternativo')
                    ->email()
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefono_1')
                    ->tel()
                    ->maxLength(255)
                    ->required()
                    ->default(null),
                Forms\Components\TextInput::make('telefono_2')
                    ->tel()
                    ->maxLength(255)
                    ->nullable()
                    ->default(null),
                
                Forms\Components\TextInput::make('direccion_1')
                    ->maxLength(255)
                    ->required()
                    ->default(null),
                Forms\Components\TextInput::make('direccion_2')
                    ->maxLength(255)
                    ->nullable()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')
                ->searchable(),
            Tables\Columns\TextColumn::make('nombre')
                ->searchable(),
            Tables\Columns\TextColumn::make('email')->label('Correo Electronico')
                ->searchable(),
            Tables\Columns\TextColumn::make('email_verified_at')->label('Fecha Verificación')
                ->date()
                ->dateTooltip()
                ->since()
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
            BadgeColumn::make('estado_usuario')
                ->formatStateUsing(fn ($state) => ucfirst($state))
                ->colors([
                    'success' => 'activo',
                    'danger' => 'inactivo',
                    'warning' => 'suspendido',
                ])
                ->sortable(),
            Tables\Columns\TextColumn::make('correo_alternativo')
                ->searchable(),
            Tables\Columns\TextColumn::make('telefono_1')
                ->searchable(),
            Tables\Columns\TextColumn::make('telefono_2')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('direccion_1')
                ->searchable(),
            Tables\Columns\TextColumn::make('direccion_2')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
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
        ])
        ->defaultSort('created_at', 'desc'); // Ordenar por fecha de creación en orden descendente
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

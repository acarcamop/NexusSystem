<?php

namespace App\Filament\Widgets;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Usuarios', User::Query()->count())
                ->description('Car Body')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Clientes', Cliente::Query()->count())
                ->description('Car Body')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Productos', Producto::Query()->count())
                ->description('Car Body')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
                Stat::make('Proveedores', Proveedor::Query()->count())
                ->description('Car Body')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }
}

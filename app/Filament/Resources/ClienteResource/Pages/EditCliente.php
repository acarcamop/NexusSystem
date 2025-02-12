<?php

namespace App\Filament\Resources\ClienteResource\Pages;

use App\Filament\Resources\ClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\ActionSize;

class EditCliente extends EditRecord
{
    protected static string $resource = ClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->size(ActionSize::Large),
        ];
    }
}

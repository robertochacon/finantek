<?php

namespace App\Filament\Resources\TypesMovementsResource\Pages;

use App\Filament\Resources\TypesMovementsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypesMovements extends ListRecords
{
    protected static string $resource = TypesMovementsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

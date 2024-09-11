<?php

namespace App\Filament\Resources\TypesLoansResource\Pages;

use App\Filament\Resources\TypesLoansResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypesLoans extends ListRecords
{
    protected static string $resource = TypesLoansResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\TypesLoansResource\Pages;

use App\Filament\Resources\TypesLoansResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypesLoans extends EditRecord
{
    protected static string $resource = TypesLoansResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

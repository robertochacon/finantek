<?php

namespace App\Filament\Resources\TypesDocumentsResource\Pages;

use App\Filament\Resources\TypesDocumentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypesDocuments extends ListRecords
{
    protected static string $resource = TypesDocumentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

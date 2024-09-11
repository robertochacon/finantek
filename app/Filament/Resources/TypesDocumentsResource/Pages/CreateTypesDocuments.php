<?php

namespace App\Filament\Resources\TypesDocumentsResource\Pages;

use App\Filament\Resources\TypesDocumentsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTypesDocuments extends CreateRecord
{
    protected static string $resource = TypesDocumentsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = auth()->user()->company_id;

        return $data;
    }
}

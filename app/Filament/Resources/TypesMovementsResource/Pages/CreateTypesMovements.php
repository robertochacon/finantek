<?php

namespace App\Filament\Resources\TypesMovementsResource\Pages;

use App\Filament\Resources\TypesMovementsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTypesMovements extends CreateRecord
{
    protected static string $resource = TypesMovementsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = auth()->user()->company_id;

        return $data;
    }
}
